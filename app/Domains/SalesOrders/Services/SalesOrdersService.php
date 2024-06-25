<?php

namespace App\Domains\SalesOrders\Services;

use App\Domains\SalesOrders\Interfaces\SalesOrderRepositoryInterface;
use App\Domains\SalesOrders\Interfaces\ReturnOrderRepositoryInterface;
use App\Domains\Addons\Interfaces\ItemsRepositoryInterface;
use App\Domains\Locations\Services\LocationsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

Class SalesOrdersService{

    private $orders_repository;
    private $returns_repository;
    private $locations_service;
    const VAT = 15;

    public function __construct(
        SalesOrderRepositoryInterface $orders_repository,
        ReturnOrderRepositoryInterface $returns_repository,
        ItemsRepositoryInterface $items_respository,
        LocationsService $locations_service,
    )
	{
        $this->orders_repository = $orders_repository;  
        $this->returns_repository = $returns_repository;  
        $this->items_respository = $items_respository;
        $this->locations_service = $locations_service;      
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $order = $this->orders_repository->create($data_model);
        
        //paintings order type
        if($request->has('paintings') && $request->paintings){
            foreach ( json_decode($request->paintings, true) as $painting) {
                $this->orders_repository->add_painting($order,$painting['id'], $painting['price']);
                $this->orders_repository->change_painting_availability($painting['id'], 'sold');
            }
        }

        //host_exhibition order type
        if($request->has('rooms') && $request->rooms){
            foreach ( json_decode($request->rooms, true) as $room) {
                $this->orders_repository->add_room($order,$room['id'], $room['price']);
            }
        }


        if($request->has('items') && $request->items){
            foreach ( json_decode($request->items, true) as $item) {
                if(!array_key_exists("status",$item)){
                    $item['status'] ='new';
                }

                if(!array_key_exists("price",$item)){
                    $item['price'] = 0;
                }

                if(!array_key_exists("quantity",$item)){
                    $item['quantity'] = 1;
                }

                if(!array_key_exists("is_delivered_back",$item)){
                    $item['is_delivered_back'] = 0;
                }
                    
                $this->orders_repository->add_item($order,$item['name'], $item['status'], $item['price'], $item['quantity'], $item['is_delivered_back']);
            }
        }


        //renting halls order type
        if($request->has('courses') && $request->courses){
            foreach ( json_decode($request->courses, true) as $course) {
                $this->orders_repository->add_course($order,$course['id'], $course['price']);
            }
        }

        if($request->has('addons') && $request->addons){
            foreach ( json_decode($request->addons, true) as $addon) {
                $this->orders_repository->add_addon($order,$addon['id'], $addon['price'], $addon['quantity']);
                $this->locations_service->quantity_to_store($order->location_id, $addon['id'], -$addon['quantity']);

            }
        }

        
        return $order;
    }
    
 

    public function get_instance(){
        $order =  $this->orders_repository->get_instance();
        $order->vat = 15;
        $order->currency = "sar";
        return $order;
    }

    public function prepare_data_table($filter){
        return $this->orders_repository->prepare_data_table($filter);
    }

    public function prepare_vendor_data_table($vendor_id){
        return $this->orders_repository->prepare_vendor_data_table($vendor_id);
    }
    
    public function prepare_customer_data_table($customer_id){
        return $this->orders_repository->prepare_customer_data_table($customer_id);
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
       
            $order =  [
                'customer_id' => $request->customer_id,
                'invoice_date'=> $request->invoice_date,
                'total' => $request->total,
                'net_total' => (($request->total - $request->discount) + ($request->total - $request->discount) * ($request->vat/100)) + $request->shipping_fees,
                'discount' => $request->discount,
                'vat' => $request->vat,
                'paid_amount' => $request->paid_amount,
                'shipping_fees' => $request->has('shipping_fees') ? $request->shipping_fees:0,
                'order_type' => $request->order_type,
                'currency' => $request->currency,
                'are_items_recieved' => $request->has('are_items_recieved') ? true : false,
                'including_materials' => $request->has('including_materials') ? true : false,
                'is_delivered' => $request->has('is_delivered') ? true : false,
                'location_id' => $request->location_id,
            ];

            if ($request->input('status')) {
                $order['status'] = $request->status;
            }

            
            //paintings order inputs
            if ($request->input('certificates_receieved')) {
                $order['certificates_receiving_date'] =  Carbon::now();
            }else{
                $order['certificates_receiving_date'] =  null;
            }

            //host_exhibition order inputs
            if ($request->has('date_from')) {
                $order['date_from'] =  $request->date_from;
            }

            if ($request->has('date_to')) {
                $order['date_to'] =  $request->date_to;
            }


            return $order;
    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            'customer_id' => $entity->customer_id,
            'invoice_date'=> $entity->invoice_date,
            'certificates_receiving_date' => $entity->certificates_receiving_date,
            'total' => $entity->total,
            'net_total' => $entity->net_total,
            'discount' => $entity->discount,
            'vat' => $entity->vat,
            'paid_amount' => $entity->paid_amount,
            'shipping_fees' => $entity->shipping_fees,
            'order_type' => $entity->order_type,
            'currency' => $entity->currency,
            'date_from' => $entity->date_from,
            'date_to' => $entity->date_to,
            'paintings' => $entity->paintings,
            'rooms' => $entity->rooms,
            'courses' => $entity->courses,
            'addons' => $entity->addons,
            'items' => $entity->items,
            'are_items_recieved' => $entity->are_items_recieved,
            'including_materials' => $entity->including_materials,
            'location_id' => $entity->location_id,
            'returns' => $entity->returnOrder,
            'status' => $entity->status,
            'is_delivered' => $entity->is_delivered,

        ];
    }
   

    public function remove_paintings($order){
        foreach ($order->paintings as $painting) {
            $this->orders_repository->change_painting_availability($painting->id, 'available');
        }
        $this->orders_repository->remove_paintings($order);
    }

    public function remove_rooms($order){
        $this->orders_repository->remove_rooms($order);
    }

    public function remove_courses($order){
        $this->orders_repository->remove_courses($order);
    }

    public function remove_items($order){
        $this->orders_repository->remove_items($order);
    }

    public function remove_addons($order){
        $this->orders_repository->remove_addons($order);   
    }


    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $order = $this->orders_repository->update($id,$data_model);
        $this->remove_paintings($order);
        if($request->has('paintings') && $request->paintings){
            foreach ( json_decode($request->paintings, true) as $painting) {
                $this->orders_repository->add_painting($order,$painting['id'], $painting['price']);
                $this->orders_repository->change_painting_availability($painting['id'], 'sold');
            }
        }

        //host_exhibition order type
        $this->remove_rooms($order);
        if($request->has('rooms') && $request->rooms){
            foreach ( json_decode($request->rooms, true) as $room) {
                $this->orders_repository->add_room($order,$room['id'], $room['price']);
            }
        }

        $this->remove_items($order);
        if($request->has('items') && $request->items){
            foreach ( json_decode($request->items, true) as $item) {
                if(!array_key_exists("status",$item)){
                    $item['status'] ='new';
                }

                if(!array_key_exists("price",$item)){
                    $item['price'] = 0;
                }

                if(!array_key_exists("quantity",$item)){
                    $item['quantity'] = 1;
                }

                if(!array_key_exists("is_delivered_back",$item)){
                    $item['is_delivered_back'] = 0;
                }
                    
                $this->orders_repository->add_item($order,$item['name'], $item['status'], $item['price'], $item['quantity'], $item['is_delivered_back']);
            }
        }


        //renting halls order type
        $this->remove_courses($order);
        if($request->has('courses') && $request->courses){
            foreach ( json_decode($request->courses, true) as $course) {
                $this->orders_repository->add_course($order,$course['id'], $course['price']);
            }
        }

        foreach($order->addons as $item){
            $this->locations_service->quantity_to_store($order->location_id, $item->id, $item->pivot->quantity);
        }
        $this->remove_addons($order);

        if($request->has('addons') && $request->addons){
            foreach ( json_decode($request->addons, true) as $addon) {
                $this->orders_repository->add_addon($order,$addon['id'], $addon['price'], $addon['quantity']);
                $this->locations_service->quantity_to_store($order->location_id, $addon['id'], -$addon['quantity']);

            }
        }

        return $order;
    }

    public function return_addons_back_to_stock($order_id, $location_id, $addons){
        foreach ($addons as $addon) {
            $this->locations_service->quantity_to_store($location_id, $addon->id, $addon->quantity);
        }
    }


    public function handle_returns($request){

        $order = $this->find($request->sales_order_id);

        $has_returns = false;
        if($order->order_type == 'paintings'){
           $has_returns =  $this->return_paintings($request->sales_order_id, $request->paintings);
        }

        if($order->order_type == 'host_exhibition'){
           $has_returns =  $this->return_rooms($request->sales_order_id, $request->rooms);
        }

        if($order->order_type == 'renting_halls'){
            $has_rooms_returns =  $this->return_rooms($request->sales_order_id, $request->rooms);
            $has_courses_returns  =  $this->return_courses($request->sales_order_id, $request->courses);
            $has_addons_returns =  $this->return_addons($order, $request->addons);
            $has_itens_returns =  $this->return_items($request->items);
            $has_returns = $has_rooms_returns || $has_courses_returns || $has_addons_returns || $has_itens_returns;
        }

        if($has_returns){
            $this->returns_repository->record_the_return($request->sales_order_id, $request->total, $request->discount);
        }else{
            $this->returns_repository->delete_by_sales_order_id($request->sales_order_id);
        }
    }


    private function return_paintings($sales_order_id, $paintings){
        $returns_count = 0;
        foreach ( json_decode($paintings, true) as $painting) {
            if($painting['is_returned']){
                $returns_count++;
            }
            $this->returns_repository->set_painting_is_returned_value($sales_order_id, $painting);
            $this->orders_repository->change_painting_availability($painting['id'], 'available');

        }

        return $returns_count;
    }

    private function return_rooms($sales_order_id, $rooms){
        $returns_count = 0;
        foreach ( json_decode($rooms, true) as $room) {
            if($room['is_returned']){
                $returns_count++;
            }
            $this->returns_repository->set_room_is_returned_value($sales_order_id, $room);
        }

        return $returns_count;
    }


    private function return_courses($sales_order_id, $courses){
        $returns_count = 0;
        foreach ( json_decode($courses, true) as $course) {
            if($course['is_returned']){
                $returns_count++;
            }
            $this->returns_repository->set_course_is_returned_value($sales_order_id, $course);
        }

        return $returns_count;
    }


    private function return_addons($order, $addons){
        $returns_count = 0;
        foreach ( json_decode($addons, true) as $addon) {
            if($addon['quantity'] > 0){
                $returns_count++;
            }
            
            $addon_entity = $this->items_respository->find($addon['id']);
            $quantity_to_stock = $addon['quantity'] - $addon_entity->returned;
            if($quantity_to_stock != 0){
                $this->locations_service->quantity_to_store($order->location_id, $addon['id'], $quantity_to_stock);
            }
            $this->returns_repository->set_addon_returned_quantity($order->id, $addon);
        }

        return $returns_count;
    }


    private function return_items($items){
        $returns_count = 0;
        foreach ( json_decode($items, true) as $item) {
            if($item['quantity'] > 0){
                $returns_count++;
            }
            $this->returns_repository->set_item_returned_quantity($item);
        }

        return $returns_count;
    }

    public function approve($order){
        $order->status = 'approved';
        $order->save();
    }    
    
    public function reject($order){
        $order->status = 'rejected';
        $order->save();
        $this->return_addons_back_to_stock($order->id, $order->location_id, $order->addons);
        foreach ($order->paintings as $painting) {
            $this->orders_repository->change_painting_availability($painting->id, 'available');
        }

    }

    private function buildCheckoutDataModel(        
        $customer_id,
        $shipping_address_id,
        $coupon_code,
        $notes,
        $total,
        $discount
    ){

        $order =  [
            'customer_id' => $customer_id,
            'invoice_date'=> Carbon::now(),
            'total' => $total,
            'net_total' => (($total - $discount) + ($total - $discount) * (self::VAT/100)),
            'discount' => $discount,
            'shipping_address_id' => $shipping_address_id,
            'vat' => self::VAT,
            'paid_amount' => (($total - $discount) + ($total - $discount) * (self::VAT/100)),
            'order_type' => 'paintings',
            'currency' => 'sar',
            'are_items_recieved' => false,
            'including_materials' =>  false,
            'status' => 'pending',
            'coupon_code' => $coupon_code,
            'notes' => $notes,

        ];
        return $order;

    }

    private function calcTotal($paintings,$currency){

        $total = 0;

        foreach ($paintings as $painting) {
            $price = ($currency == 'sar') ? $painting->price:$painting->price_euro;
            $total += $price;
        }
    
        return $total;
    }
    public function proccessCustomerOrder(
        $paintings,
        $customer_id,
        $shipping_address,
        $coupon_code,
        $notes,
        $discount
     ){
        $total = $this->calcTotal($paintings,'sar');
        $discount = $discount  ? $total * ($discount/100):0;
        $data_model = $this->buildCheckoutDataModel(        
            $customer_id,
            $shipping_address->id,
            $coupon_code,
            $notes,
            $total,
            $discount
        );
        
        $order = $this->orders_repository->create($data_model);
        
        foreach ($paintings as $painting) {
            $this->orders_repository->add_painting($order,$painting->id, $painting->price);
            $this->orders_repository->change_painting_availability($painting->id, 'sold');
        }


        $order->fresh();
        return $order;
     }

}
