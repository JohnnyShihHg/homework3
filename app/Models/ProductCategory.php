<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{

    protected $table = 'product_categories';

    protected $fillable = [
        'name', 'price',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_categories_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'orders_id');
    }
}
