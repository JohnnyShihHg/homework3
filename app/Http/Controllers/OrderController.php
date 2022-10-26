<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $OrderService;

    public function __construct(OrderService $OrderService)
    {
        $this->OrderService = $OrderService;
    }

    /**
     * @OA\Get(
     *   tags={"Order"},
     *   path="/order",
     *   summary="拿到所有的訂單資訊",
     *   @OA\Response(response=200, description="OK",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example={
     *                    {
     *                    "id": 1,
     *                    "users_id": 3,
     *                    "order_no": "202210210601592823",
     *                    "order_sum": "0.00",
     *                    "status": 1,
     *                    "created_at": "2022-10-21 06:01:59",
     *                    "updated_at": "2022-10-21 06:01:59"
     *                   }
     *              }
     *          )
     *       }
     *   )
     * )
     */

    public function index()
    {
        $order = $this->OrderService->index();

        return $order;
    }

    /**
     * @OA\Post(
     *   tags={"Order"},
     *   path="/order",
     *   summary="訂單結帳 ( 需登入 )",
     *   security={{"user_token":{}}},
     *   @OA\Response(response=200, description="Order successfully",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "message": "Order successfully"
     *                   }
     *          )
     *       }
     *   ),
     * @OA\Response(response=400, description="Your Cart is empty",
     * content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "message": "Your Cart is empty"
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
        $store = $this->OrderService->store();

        return $store;
    }

    /**
     * @OA\Get(
     *   tags={"Order"},
     *   path="/order/detail/{order_no}",
     *   summary="拿到指定訂單的詳細資訊 ( 需登入 )",
     *   @OA\Parameter(parameter="order_no",in="path",name="order_no",required=true,description="input your order_no"),
     *   security={{"user_token":{}}},
     *   @OA\Response(response=200, description="OK",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example={
     *                    {
     *                    "id": 6,
     *                    "users_id": 3,
     *                    "order_no": "202210210700393083",
     *                    "order_sum": "81.00",
     *                    "status": 1,
     *                    "created_at": "2022-10-21 07:00:39",
     *                    "updated_at": "2022-10-21 07:00:39",
     *                    "user": {
     *                        "id": 3,
     *                        "account": "johnny2",
     *                        "phone_no": "1212122222"
     *                    },
     *                        "detail": {
     *                                  "id": 1,
     *                                  "orders_id": 6,
     *                                  "product_categories_id": 4,
     *                                  "product_price": "55.00",
     *                                  "product_count": "1.00"
     *                              }
     *                   }
     *              }
     *          )
     *       }
     *   ),
     * @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function detail($order_no)
    {
        $detail = $this->OrderService->detail($order_no);

        return $detail;
    }
}
