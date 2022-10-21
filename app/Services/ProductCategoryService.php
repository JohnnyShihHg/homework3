<?php

namespace App\Services;

use App\Models\ProductCategory;
use App\Models\Product;

class ProductCategoryService
{
    /**
     * 列出所有商品
     */

    public static function index()
    {
        return ProductCategory::with('products')->get();
    }
}
