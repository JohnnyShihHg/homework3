<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'users_id', 'order_no', 'order_sum'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function detail()
    {
        return $this->hasMany(OrderDetail::class, 'orders_id');
    }
}
