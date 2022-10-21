<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'users_id', 'product_categories_id', 'count'
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_categories_id');
    }
}
