<?php

namespace App\Domains\SalesOrders\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\SalesOrders\Entities\ReturnOrder;
use App\Domains\SalesOrders\Interfaces\ReturnOrderRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  ReturnOrderRepository extends BaseRepository implements ReturnOrderRepositoryInterface
{

    /**
    * ReturnOrderRepository constructor.
    *
    * @param ReturnOrder $model
    */
    public function __construct(ReturnOrder $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT returns.*
        FROM   returns
                 order by returns.id ASC
                 ");
    }

    public function record_the_return($sales_order_id, $returned_total, $returned_discount){
        $return_order = $this->model::firstOrCreate([
            'sales_order_id' => $sales_order_id,
        ])->update(['returned_total' => $returned_total, 'returned_discount' => $returned_discount]);
    }


    public function set_painting_is_returned_value($sales_order_id, $painting){
        DB::table('sold_paintings')
            ->where('salesorder_id', $sales_order_id)
            ->where('painting_id', $painting['id'])
            ->update(['is_returned' => $painting['is_returned']]);
    }

    public function set_room_is_returned_value($sales_order_id, $room){
        DB::table('sales_orders_room')
            ->where('sales_order_id', $sales_order_id)
            ->where('room_id', $room['id'])
            ->update(['is_returned' => $room['is_returned']]);
    }

    public function set_course_is_returned_value($sales_order_id, $course){
        DB::table('sales_orders_course')
            ->where('sales_order_id', $sales_order_id)
            ->where('course_id', $course['id'])
            ->update(['is_returned' => $course['is_returned']]);
    }

    public function set_addon_returned_quantity($sales_order_id, $addon){
        DB::table('sales_orders_addons_items')
            ->where('sales_order_id', $sales_order_id)
            ->where('addon_item_id', $addon['id'])
            ->update(['returned' => $addon['quantity']]);
    }


    public function set_item_returned_quantity($item){
        DB::table('sales_orders_items')
            ->where('id', $item['id'])
            ->update(['returned' => $item['quantity']]);
    }

    public function delete_by_sales_order_id($sales_order_id){
        $this->model::where('sales_order_id', $sales_order_id)->delete();
    }


}
