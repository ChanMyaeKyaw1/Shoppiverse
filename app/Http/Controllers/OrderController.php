<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;

class OrderController extends Controller
{
    // direct to order list page
    public function orderList() {
        $orderLists = Order::select('products.id as product_id', 'products.stock', 'orders.count',
            'orders.id', 'orders.order_code', 'orders.created_at', 'orders.status', 'users.name')
                            ->leftJoin('users', 'orders.user_id', 'users.id')
                            // ->groupBy('order_code')
                            ->leftJoin('products', 'orders.product_id', 'products.id')
                            ->orderBy('orders.created_at', 'desc')
                            ->get();
        $orderList = $orderLists->groupBy('order_code');

        // dd($orderList->toArray());
        return view('admin.order.list', compact('orderList'));
    }

    // order details
    public function orderDetails($orderCode) {
        $order = Order::select('users.name as user_name', 'users.phone as user_phone', 'users.address',
        'orders.id as order_id', 'orders.user_id', 'orders.count as order_count', 'orders.order_code', 'orders.created_at',
        'products.id as product_id','products.name as product_name', 'products.image', 'products.price', 'products.stock')

                        ->leftJoin('products', 'orders.product_id', 'products.id')
                        ->leftJoin('users', 'orders.user_id', 'users.id')
                        ->where('orders.order_code', $orderCode)
                        ->get();

        $paymentHistory = PaymentHistory::select('payment_histories.*', 'payments.type as payment_type')
                                        ->leftJoin('payments', 'payments.id', 'payment_histories.payment_method')
                                        ->where('order_code', $orderCode)->first();
        // dd($order->toArray());


        $status = true;

        foreach($order as $item) {
            if( $item->order_count <= $item->stock ) {
                $status = true;
            } else {
                $status = false;
                break;
            }
        }

        return view('admin.order.details', compact('order', 'paymentHistory', 'status'));
    }

    // order reject (api)
    public function orderReject(Request $request) {

        Order::where('order_code', $request->orderCode)->update([
            'status' => 2
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'order reject successfully...'
        ], 200);
    }

    // order status change (api)
    public function orderStatusChange(Request $request) {

        Order::where('order_code', $request->order_code)->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'order status changed successfully...'
        ], 200);
    }

    public function orderConfirm(Request $request) {
        $orderList = $request->all(); // this will be the array sent from JS

        if(count($orderList) == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No order data received'
            ], 400);
        }

        // Update order status (assuming all items have the same order_code)
        $orderCode = $orderList[0]['order_code'];
        Order::where('order_code', $orderCode)->update([
            'status' => 1
        ]);

        // Decrement stock for each product
        foreach ($orderList as $item) {
            Product::where('id', $item['product_id'])->decrement('stock', $item['count']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Stock decremented and order confirmed successfully.'
        ], 200);
    }


}
