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
     * @OA\Post(
     *   tags={"Cart"},
     *   path="/cart",
     *   summary="成立購物車 ( 需登入 )",
     *   security={{"user_token":{}}},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *          mediaType="multipart/form-data",
     *   @OA\Schema(
     *         required={"product_categories_id"},
     *         @OA\Property(property="product_categories_id", type="integer", description="商品ID", example="1"),
     *       )
     *     )
     *   ),
     *   @OA\Response(response=200, description="Add cart successful",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "message": "Add cart successful"
     *                   }
     *          )
     *       }
     *   ),
     * @OA\Response(response=400, description="Product is out of stock",
     * content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "message": "Product is out of stock"
     *                   }
     *          )
     *       }),
     * @OA\Response(response=401, description="Unauthorized",
     * content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "message": "Token not provided"
     *                   }
     *          )
     *       })
     * )
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
