<?php

namespace App\Domains\SalesOrders\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\SalesOrders\Entities\SalesOrder;
use App\Domains\Paintings\Entities\Paintings;
use App\Domains\SalesOrders\Interfaces\SalesOrderRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class  SalesOrderRepository extends BaseRepository implements SalesOrderRepositoryInterface
{

    /**
    * SalesOrderRepository constructor.
    *
    * @param SalesOrder $model
    */
    public function __construct(SalesOrder $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table($filter)
        {
            $query = DB::table('sales_orders')
                ->leftJoin('returns', 'sales_orders.id', '=', 'returns.sales_order_id')
                ->leftJoin('customers', 'sales_orders.customer_id', '=', 'customers.id')
                ->select('sales_orders.*', 'returns.id as return_id');

            if ($filter) {
                $fromDate = $filter['from'] ? Carbon::createFromFormat('Y-m-d', $filter['from'])->format('Y-m-d') : null;
                $toDate =   $filter['to'] ? Carbon::createFromFormat('Y-m-d', $filter['to'])->format('Y-m-d') : null;
              
                if (!empty($filter['from'])) {
                    $query->whereDate('sales_orders.invoice_date', '>=', $fromDate);
                }

                if (!empty($filter['to'])) {
                    $query->whereDate('sales_orders.invoice_date', '<=', $toDate);
                }

                if (!empty($filter['status'])) {
                    $query->where('sales_orders.status', $filter['status']);
                }

                if (!empty($filter['phone'])) {
                    $query->where('customers.phone', 'like', '%' .$filter['phone']. '%');
                }
            }

            $query->orderBy('sales_orders.id', 'asc');

            return $query->get();
        }



    public function prepare_vendor_data_table($vendor_id){

        return DB::select("
                            select
                                so.id,
                                p.name,
                                sp.price ,
                                sp.is_returned,
                                so.status,
                                so.created_at
                            from
                                paintings p
                            inner join sold_paintings sp on
                                p.id = sp.painting_id
                            inner join sales_orders so on
                                sp.salesorder_id = so.id
                            where
                                so.status in ('approved','rejected','pending')
                                and vendor_id = $vendor_id
    
                 ");
    }


    public function prepare_customer_data_table($customer_id){

        return DB::select("
                            select
                                sales_orders.*,
                                returns.id as return_id
                            from
                                sales_orders
                            left join returns on
                                sales_orders.id = returns.sales_order_id
                            where sales_orders.customer_id = $customer_id
                            order by
                                sales_orders.id asc
    
                 ");
    }

    public function add_painting($order, $painting_id, $price){
        $order->paintings()->attach($painting_id, ['price' => $price]);
    }


    public function remove_paintings($order){
        $order->paintings()->detach();
    }

    public function add_room($order, $room_id, $price){
        $order->rooms()->attach($room_id, ['price' => $price]);
    }


    public function remove_rooms($order){
        $order->rooms()->detach();
    }

    public function add_course($order, $course_id, $price){
        $order->courses()->attach($course_id, ['price' => $price]);
    }


    public function remove_courses($order){
        $order->courses()->detach();
    }

    public function add_addon($order, $addon_id, $price, $quantity){
        $order->addons()->attach($addon_id, ['price' => $price, 'quantity' => $quantity]);
    }


    public function remove_addons($order){
        $order->addons()->detach();
    }

    public function add_item($order, $name, $status, $price, $quantity, $is_delivered_back){
        $order->items()->create([
            'name' => $name,
            'status' => $status,
            'price' => $price,
            'quantity' => $quantity,
            'is_delivered_back' => $is_delivered_back,
        ]);
    }


    public function remove_items($order){
        $order->items()->delete();
    }

    public function change_painting_availability($painting_id, $status){
        Paintings::where('id', $painting_id)
        ->update(['status' => $status]);
    }

}
