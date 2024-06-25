<?php

namespace App\Domains\SalesOrders\Entities;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice_date',
        'certificates_receiving_date',
        'is_delivered',
        'total',
        'net_total',
        'discount',
        'vat',
        'paid_amount',
        'shipping_fees',
        'order_type',
        'currency',
        'date_from',
        'date_to',
        'are_items_recieved',
        'including_materials',
        'location_id',
        'status',
        'coupon_code',
        'shipping_address_id',
        'notes'
    ];

    public function employee()
    {
        return $this->belongsTo( \App\Models\User::class, 'created_by');
    }

    /**
     * Get purchase order items.
     */
    public function paintings()
    {
        return $this->belongsToMany(
            \App\Domains\Paintings\Entities\Paintings::class,
            'sold_paintings',
            'salesorder_id',
            'painting_id'
            )->withPivot('price','is_returned');
    }

    /**
     * Get purchase order rooms.
     */
    public function rooms()
    {
        return $this->belongsToMany(
            \App\Domains\Rooms\Entities\Rooms::class,
            'sales_orders_room',
            'sales_order_id',
            'room_id'
            )->withPivot('price','is_returned');
    }

    /**
     * Get purchase order courses.
     */
    public function courses()
    {
        return $this->belongsToMany(
            \App\Domains\Courses\Entities\Course::class,
            'sales_orders_course',
            'sales_order_id',
            'course_id'
            )->withPivot('price','is_returned');
    }

    public function items()
    {
        return $this->hasMany(
            \App\Domains\SalesOrders\Entities\SalesOrderItem::class,
            'order_id',
            'id'
        );
    }

    public function returnOrder()
    {
        return $this->hasOne(ReturnOrder::class,'sales_order_id','id');
    }

    /**
     * Get sales order addon items.
     */
    public function addons()
    {
        return $this->belongsToMany(
            \App\Domains\Addons\Entities\Items::class,
            'sales_orders_addons_items',
            'sales_order_id',
            'addon_item_id'
            )->withPivot('price','quantity','returned');
    }
    

    public function customer()
    {
        return $this->belongsTo(\App\Domains\Customers\Entities\Customers::class);
    }

    public function save(array $options = [])
    {
        // Generate a new serial number if it's not already set
        if (!$this->created_by &&  auth()->user()) {
            $this->created_by = auth()->id();
        }

        return parent::save($options);
    }

}