<?php

namespace App\Domains\SalesOrders\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    use HasFactory;
    protected $table = 'sales_orders_items';

    protected $fillable = [
        'name',
        'status',
        'price',
        'quantity',
        'is_delivered_back',
        'order_id',
    ];
}
