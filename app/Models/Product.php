<?php

namespace App\Models;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_categories_id', 'size', 'color', 'stock'
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_categories_id');
    }
}
