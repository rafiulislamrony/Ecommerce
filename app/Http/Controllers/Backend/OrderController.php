<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    //
    public function PendingOrders(){
        $orders = Order::where('status', 'Pending')->orderBy('id','DESC')->get();
        return view('backend.orders.pending_orders', compact('orders'));
    }
    public function PendingOrdersDetails($order_id){
        $order = Order::with('division','district','state','user')->where('id', $order_id)->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id','DESC')->get();
        return view('backend.orders.pending_orders_details', compact('order', 'orderItem'));
    }
    public function ConfirmedOrders(){
        $orders = Order::where('status', 'confirmed')->orderBy('id','DESC')->get();
        return view('backend.orders.confirmed_orders', compact('orders'));
    }
    public function ProcessingOrders(){
        $orders = Order::where('status', 'processing')->orderBy('id','DESC')->get();
        return view('backend.orders.processing_orders', compact('orders'));
    }
    public function PickedOrders(){
        $orders = Order::where('status', 'picked')->orderBy('id','DESC')->get();
        return view('backend.orders.picked_orders', compact('orders'));
    }
    public function ShippedOrders(){
        $orders = Order::where('status', 'shipped')->orderBy('id','DESC')->get();
        return view('backend.orders.shipped_orders', compact('orders'));
    }
    public function DaliveredOrders(){
        $orders = Order::where('status', 'dalivered')->orderBy('id','DESC')->get();
        return view('backend.orders.dalivered_orders', compact('orders'));
    }
    public function CancelOrders(){
        $orders = Order::where('status', 'cancel')->orderBy('id','DESC')->get();
        return view('backend.orders.cancel_orders', compact('orders'));
    }

}
