<?php

namespace App\Domains\PurchaseOrders\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\PurchaseOrders\Entities\PurchaseOrder;
use App\Domains\PurchaseOrders\Interfaces\PurchaseOrderRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  PurchaseOrderRepository extends BaseRepository implements PurchaseOrderRepositoryInterface
{

    /**
    * PurchaseOrderRepository constructor.
    *
    * @param PurchaseOrder $model
    */
    public function __construct(PurchaseOrder $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT purchase_orders.*
        FROM   purchase_orders
                 order by purchase_orders.id ASC
                 ");
    }

    public function add_item($order, $item_id, $price, $price_euro ,$quantity,$is_recieved){
        $order->items()->attach($item_id, ['price' => $price, 'price_euro' => $price_euro, 'quantity' => $quantity,'is_recieved' => $is_recieved ]);
    }


    public function remove_items($order){
        $order->items()->detach();
    }

}
