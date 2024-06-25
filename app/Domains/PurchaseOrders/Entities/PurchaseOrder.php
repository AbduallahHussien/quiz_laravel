<?php

namespace App\Domains\PurchaseOrders\Entities;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'order_number',
        'supplier_id',
        'location_id',
        'purchase_date',
        'total_price',
        'total_price_euro',
    ];

    /**
     * Get purchase order items.
     */
    public function items()
    {
        return $this->belongsToMany(
            \App\Domains\Addons\Entities\Items::class,
            'purchase_orders_addons_items',
            'purchase_order_id',
            'addon_item_id'
            )->withPivot('price','price_euro', 'quantity','is_recieved');
    }


}