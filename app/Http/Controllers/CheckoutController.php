<?php

namespace App\Http\Controllers;

use App\Address;
use App\Order;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');


    }

    public function DisplayAddressForm()
    {
        if(!Session::has('ShopingCard') || count(Session::get('ShopingCard')) < 1 )
        {
          return redirect()->back();
        }
        return view('AddressForm');
    }

    public function SaveOrder(Request $request)
    {
        if(!Session::has('Books') || count(Session::get('Books')) < 1 || !Session::has('totalPrice') || Session::get('totalPrice') <= 0  || !Session::has('ShopingCard'))
        {
          return redirect()->back();
        }
        $items = Session::get('Books');
        $price = Session::get('totalPrice');
        $user = $request->user();
        foreach($items as $item)


        $this->validate($request, [
            'address' => 'required|string|between:5,50',
            'city' => 'required|string|between:3,20',
            'phone_number' => 'required|max:20|regex:/[0-9]/',
            'postal_code' => 'required|regex:/^[0-9]{2}-[0-9]{3}$/',
            'terms' => 'required'
        ]);

        $sameAddress = DB::table('addresses')//chyba tego nie testowałe
            ->where('address', $request['address'])
            ->where('city', $request['city'])
            ->where('postal_code', $request['postal_code'])
            ->first();
        if ($sameAddress) {
            $address = $sameAddress;
        }
        else
        {
            $address = new Address();
            $address->address = $request['address'];
            $address->city = $request['city'];
            $address->postal_code = $request['postal_code'];
            $user->addreses()->save($address);
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->address_id = $address->id;
        $order->price = $price;
        $order->phone_number = $request->phone_number;
        $order->status = "Oczekiwanie na wpłate";//zamówienie wpłynęło do systemu i oczekuje na realizację (najpierw musi byc wpłata)

        DB::transaction(function() use ($order,$items,$user) {

            $order->save();
            $book_order = array();
            $book_user = array();
            for($i = 0 ; $i < count($items) ; $i++)
            {
                $helperArray = array("book_id" => $items[$i]['id'], "quantity" =>$items[$i]['quantity'] ,"order_id" => $order->id);
                $helperArray1 = array("book_id" => $items[$i]['id'],"user_id" => $user->id, "order_status" => 0);

                $items[$i] = null;

                array_push($book_order,$helperArray);
                array_push($book_user,$helperArray1);
            }
            DB::table('book_order')->insert($book_order);
            DB::table('book_user')->insert($book_user);
        });



        $orderItems = json_decode(json_encode($items), FALSE);
        Mail::send('emails.order-details', ['order_id' =>$order->id, "price"=>$price, "items" => $orderItems], function ($m) use ($user) {
            $m->from('testowekontodonauki@gmail.com', 'Test Aplikacji');

            $m->to($user->email, $user->name)->subject('Sczegóły zamówienia');
        });
        Session::forget('totalPrice');
        Session::forget('Books');
        Session::forget('ShopingCard');


        return view('order-details',['price' => $price , 'orderId' =>$order->id,"items" => $orderItems]);
    }
}
