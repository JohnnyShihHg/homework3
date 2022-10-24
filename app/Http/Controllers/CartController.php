<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CartStoreRequest;

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
    public function store(CartStoreRequest $request)
    {
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
