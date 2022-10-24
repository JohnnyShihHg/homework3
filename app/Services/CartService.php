<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CartStoreRequest;
use Exception;

class CartService
{
    /**
     * 列出所有商品
     */

    public static function store(CartStoreRequest $request)
    {
        try {
            Cart::create([
                'users_id' => Auth::user()->id,
                'product_categories_id' => $request->input('product_categories_id'),
                'count' => $request->input('count', 1),
            ]);

            return response()
                ->json([
                    'status' => true,
                    'message' => 'Add cart successful'
                ], 200);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'Product is out of stock'
                ], 400);
        }
    }
}
