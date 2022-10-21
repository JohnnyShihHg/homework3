<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'orders_id', 'product_categories_id', 'product_price', 'product_count'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_categories_id');
    }
}
