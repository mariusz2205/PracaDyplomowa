<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ShopingCardController extends Controller
{
    public function UpdateItemNumber(Request $request)
    {
        if(Session::has('ShopingCard'))
        {
            $items = Session::get('ShopingCard');
        }
        else
        {
            $items = [];
        }

        if($request['bookId'] == null)
        {
            return count($items);
        }
        $bookId = $request['bookId'];
        array_push($items,$bookId);
        Session::put('ShopingCard',$items );
        return count($items);
    }

    public function DispleyShopingCard()
    {
        $items = null;
        $books = null;
        $data = [];
        $totalPrice = 0;

        if(Session::has('ShopingCard'))
        {
            $books_ids = Session::get('ShopingCard');

            $books = DB::table('books')->select('id','title','price')->whereIn('id',$books_ids)->get();

            //zamiana $books na tablice
            $books=array_map(function($item){
                return (array) $item;
            },$books);

            foreach ($books as $book)
            {
                $currentId = $book['id'];
                $counter = 0;
                foreach($books_ids as $id)
                {
                    if($id == $currentId)
                    {
                        $counter++;
                    }
                }
                $helperArray= array('title' => $book['title'],
                                    'price' => $book['price'],
                                    'quantity' => $counter,
                                    'id' => $book['id']);

                $totalPrice += $helperArray['price']*$helperArray['quantity'];
                $totalPrice += 0.00;//chodzi o to by zawsze był to typ float by przechodziło testy
                array_push($data,$helperArray);
            }
            Session::put('Books', $data);
            Session::put('totalPrice', $totalPrice);
           $data = json_decode(json_encode($data), FALSE);
        }
        return view('ShopingCard',['books'=>$data, 'totalPrice'=>$totalPrice]);
    }

    public function RemoveItem($bookId)
    {

        $oldItems = Session::get('ShopingCard');
        $items = [];
        foreach($oldItems as $value)
        {
            if($bookId != $value && $value != null)
            {
                array_push($items,$value);
            }
        }

        Session::put('ShopingCard', $items);
        return redirect()->route('shopingCard');
    }

    public function AddOneItem($bookId)
    {
        $items = Session::get('ShopingCard');
        array_push($items,$bookId);
        Session::put('ShopingCard', $items);
        return redirect()->route('shopingCard');
    }
    public function RemoveOneItem($bookId)
    {
        $oldItems = Session::get('ShopingCard');
        $items = [];
        $counter = 0;
        foreach($oldItems as $value)
        {
            if($value != null )
            {
                if(!($value == $bookId && $counter == 0))
                {
                    array_push($items,$value);
                }
                else
                {
                    $counter++;
                }

            }
        }

        Session::put('ShopingCard', $items);
        return redirect()->route('shopingCard');
    }

}
