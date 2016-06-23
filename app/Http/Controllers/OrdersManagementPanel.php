<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrdersManagementPanel extends Controller
{

    public function setOrderNumberSessionVariable(Request $request)
    {
        $orderNumber = $request->orderNumber;
        Session::put('OrderNumber',$orderNumber);
        return redirect()->route('ShowOrders');
    }

    public function ShowOrders()
    {
        if(Session::has('OrderNumber'))
        {
            $orderNumber = Session::get('OrderNumber');
        }
        else
        {
            $order = DB::table('orders')->orderBy('id', 'desc')->first();
            $orderNumber = $order->id;


        }
        if($orderNumber == 1)
        {
          $orderNumber = 0; // jakiś błąd z 1 był 
        }
        $order = Order::with(['user','address','books'])->where('id','=', $orderNumber )->first();

        return view('OrdersManagementPanelViews.orders', ['order' => $order]);
    }

    public function changeOrderStatus($id, $status)
    {
        $order = Order::where('id',$id)->update(['status'=>$status]);

        return redirect()->back();
    }
}
