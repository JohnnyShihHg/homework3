<?php

namespace App\Services;

// use App\Models\ProductCategory;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    /**
     * 列出所有商品
     */

    public static function index()
    {
        return Order::all();
    }

    public function store()
    {
        //目前的資料都由資料庫提供即可

        //所有人
        $users_id = Auth::user()->id;
        //訂單編號
        $order_no = date('YmdHis') . rand(100, 900) . $users_id;

        $amount = 0;

        $cart = Cart::where('users_id', $users_id)
            ->with('productCategory:id,price')
            ->where('is_checked', 1)
            ->get()->toArray();

        if (!$cart) {
            return response()->json([
                'message' => 'Your Cart is empty'
            ], 400);
        }
        $insertOrderDetail = [];

        foreach ($cart as $value) {
            $insertOrderDetail[] = [
                'product_categories_id' => $value['product_category']['id'],
                'product_price' => $value['product_category']['price'],
                'product_count' => $value['count']
            ];

            $amount += $value['product_category']['price'] * $value['count'];
        }

        try {

            DB::beginTransaction();

            //產生訂單
            $order = Order::create([
                'users_id' => $users_id,
                'order_no' => $order_no,
                'order_sum' => $amount,
            ]);

            //訂單名細
            $order->detail()->createMany($insertOrderDetail);

            //移除購物車
            Cart::where('users_id', $users_id)
                ->with('productCategory:id,price')
                ->where('is_checked', 1)
                ->delete();

            DB::commit();

            return response()->json([
                'message' => 'Order successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function detail($order_no)
    {
        $order = Order::where('order_no', $order_no)
            ->with('user:id,account,phone_no', 'detail:id,orders_id,product_categories_id,product_price,product_count')
            ->get();

        return $order;
    }
}
