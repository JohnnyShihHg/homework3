<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $CartService;

    public function __construct(CartService $CartService)
    {
        $this->CartService = $CartService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * 加入購物車
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_categories_id' => 'required|exists:product_categories,id'
        ]);

        $store = $this->CartService->store($request);

        return $store;
    }

    /**
     * 更新數量
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     *移除購物車
     */
    public function destroy($id)
    {
        //
    }
}
