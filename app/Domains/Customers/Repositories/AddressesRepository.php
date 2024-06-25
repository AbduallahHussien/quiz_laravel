<?php

namespace App\Domains\Customers\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Customers\Entities\Addresses;
use App\Domains\Customers\Interfaces\AddressesRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  AddressesRepository extends BaseRepository implements AddressesRepositoryInterface
{

    /**
    * CustomersRepository constructor.
    *
    * @param Customers $model
    */
    public function __construct(Addresses $model)
    {
        parent::__construct($model);
    }


    public function prepare_data_table($customer_id){

        return DB::select("
                            select addresses.*, sales_orders.id as shipping_address from addresses
                            left join sales_orders
                            on addresses.id = sales_orders.shipping_address_id
                            where addresses.customer_id = $customer_id
                        ");
    }


    public function getDefaultAddress($customer_id){
        return $this->model::where('customer_id', $customer_id)
        ->where('is_default', true)->first();
    }

    public function updateAddress($address_id, $billing_address){
        $this->model::where('id', $address_id)->update($billing_address);
    }

    public function getLastShippingAddress($customer_id){
        return $this->model::where('customer_id', $customer_id)->latest()->first();
    }
}
