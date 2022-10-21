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

    public function index()
    {
        $order = $this->OrderService->index();

        return $order;
    }

    public function store(Request $request)
    {
        $store = $this->OrderService->store();

        return $store;
    }

    public function detail($order_no)
    {
        $detail = $this->OrderService->detail($order_no);

        return $detail;
    }
}
