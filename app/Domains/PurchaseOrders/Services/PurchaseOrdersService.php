<?php

namespace App\Domains\PurchaseOrders\Services;

use App\Domains\PurchaseOrders\Interfaces\PurchaseOrderRepositoryInterface;
use App\Domains\Locations\Services\LocationsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class PurchaseOrdersService{

    private $orders_repository;
    private $locations_service;

    public function __construct(
        PurchaseOrderRepositoryInterface $orders_repository,
        LocationsService $locations_service,
    )
	{
        $this->orders_repository = $orders_repository;       
        $this->locations_service = $locations_service;       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $order = $this->orders_repository->create($data_model);
        if($request->items){
            foreach ( json_decode($request->items, true) as $item) {
                $this->orders_repository->add_item($order,$item['id'], $item['price'], $item['price_euro'] ,$item['quantity'],$item['is_recieved']);
                if($item['is_recieved']){
                    $this->locations_service->quantity_to_store($order->location_id, $item['id'], $item['quantity']);
                }
            }
        }
        
        return $order;
    }
    
 

    public function get_instance(){
        return $this->orders_repository->get_instance();
    }

    public function prepare_data_table(){
        return $this->orders_repository->prepare_data_table();
    }

    public function all(){
        return $this->orders_repository->all();
    }

    public function find($id){
        return $this->orders_repository->find($id);
    }

    public function delete($id){
        $this->orders_repository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                'order_number' => $request->order_number,
                'supplier_id' => $request->supplier_id,
                'location_id' => $request->location_id,
                'purchase_date' => $request->purchase_date,
                'total_price' => $request->total_price,
                'total_price_euro' => $request->total_price_euro,
            ];
    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            'order_number' => $entity->order_number,
            'supplier_id' => $entity->supplier_id,
            'location_id' => $entity->location_id,
            'purchase_date' => $entity->purchase_date,
            'total_price' => $entity->total_price,
            'total_price_euro' => $entity->total_price_euro,
            'items' => $entity->items,
        ];
    }
   

    public function remove_items($order){
        foreach($order->items as $item){
            if($item->pivot->is_recieved){
                $this->locations_service->quantity_to_store($order->location_id, $item->id, -$item->pivot->quantity);
            }

      
        }
        $this->orders_repository->remove_items($order);
    }


    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $order = $this->orders_repository->update($id,$data_model);
        $this->remove_items($order);
        if($request->items){
            foreach ( json_decode($request->items, true) as $item) {
                $this->orders_repository->add_item($order,$item['id'], $item['price'], $item['price_euro'] ,$item['quantity'], $item['is_recieved']);
                if($item['is_recieved']){
                    $this->locations_service->quantity_to_store($order->location_id, $item['id'], $item['quantity']);
                }
            }
        }

        return $order;
    }

}
