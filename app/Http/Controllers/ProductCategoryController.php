<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductCategoryService;

class ProductCategoryController extends Controller
{
    protected $ProductCategoryService;

    public function __construct(ProductCategoryService $ProductCategoryService)
    {
        $this->ProductCategoryService = $ProductCategoryService;
    }

    /**
     * 列出所有商品
     */

    public function index()
    {
        $products = $this->ProductCategoryService->index();

        return $products;
    }
}
