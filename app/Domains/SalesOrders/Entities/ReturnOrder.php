<?php

namespace App\Domains\SalesOrders\Entities;

use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model
{
    protected $table = 'returns';
    protected $fillable = [
        'sales_order_id',
        'returned_total',
        'returned_discount',
    ];
    protected $attributes = [
        'returned_total' => 0,
        'returned_discount' => 0,
    ];

}