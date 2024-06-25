<?php

namespace App\Domains\Customers\Services;

use App\Domains\Customers\Interfaces\AddressesRepositoryInterface;
use App\Domains\Customers\Interfaces\CustomersRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

Class AddressesService{

    private $addresses_respository;

    public function __construct(
        AddressesRepositoryInterface $addresses_respository,
        CustomersRepositoryInterface $customers_respository,
    )
	{
        $this->addresses_respository = $addresses_respository;       
        $this->customers_respository = $customers_respository;       
	}

    public function create($request,$customer_id, $is_default= false){

        $data_model = $this->request_to_data_model($request);
        $data_model['customer_id'] = $customer_id;
        if($is_default){
            $data_model['is_default'] = $is_default;
        }
        $address = $this->addresses_respository->create($data_model);
        return $address;

    }

    public function update($id,$request){       
        $data_model = $this->request_to_data_model($request);
        $address = $this->addresses_respository->update($id,$data_model);
        return $address;
    }

    public function get_instance(){
        return $this->addresses_respository->get_instance();
    }

    public function getCustomerAddress($type, $customer_id = null){
        $address_entity = $this->get_instance();
        if(!$customer_id){
            return $address_entity;
        }else if($type == 'billing'){
            $billing_address =  $this->addresses_respository->getDefaultAddress($customer_id);
            return $billing_address ? $billing_address:$address_entity;
        }else{
            $shipping_address =  $this->addresses_respository->getLastShippingAddress($customer_id);
            return $shipping_address ? $shipping_address:$address_entity;
        }
    }


    public function prepare_data_table($customer_id){
        return $this->addresses_respository->prepare_data_table($customer_id);
    }

    public function all(){
        return $this->addresses_respository->all();
    }

    public function find($id){
        return $this->addresses_respository->find($id);
    }

    public function delete($id){
        $this->addresses_respository->delete($id);
    }


    private function request_to_data_model($request){
       
            return 
            [
            "first_name"  => $request->first_name,
            "last_name"  => $request->last_name,
            "company_name"  => $request->company_name,
            "address_line1"  => $request->address_line1,
            "address_line2"  => $request->address_line2,
            "email"  => $request->email,
            "phone"  => $request->phone,
            "country_id"  => $request->country_id,
            "city"  => $request->city,
            "state"  => $request->state,
            "postal_code"  => $request->postal_code
        ];
    }


    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "first_name"  => $entity->first_name,
            "last_name"  => $entity->last_name,
            "company_name"  => $entity->company_name,
            "address_line1"  => $entity->address_line1,
            "address_line2"  => $entity->address_line2,
            "email"  => $entity->email,
            "phone"  => $entity->phone,
            "country_id"  => $entity->country_id,
            "city"  => $entity->city,
            "state"  => $entity->state,
            "postal_code"  => $entity->postal_code
        ];
    }

    
    public function updateCustomerBillingAddress($customer_id, $billing_address){
        $address = $this->addresses_respository->getDefaultAddress($customer_id);
        if($address){
            $this->addresses_respository->updateAddress($address->id, $billing_address);
            $address->fresh();
        }else{
            $address = $this->create((object)  $billing_address, $customer_id, true);
        }
        
        return $address;
    }

    public function createShippingAddress($customer_id, $shipping_address){
        return $this->create((object)  $shipping_address, $customer_id, false);
    }

    public function countries(){
        return $this->customers_respository->countries();
    }
   
}
