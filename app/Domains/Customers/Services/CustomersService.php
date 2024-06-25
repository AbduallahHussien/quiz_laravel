<?php

namespace App\Domains\Customers\Services;

use App\Domains\Customers\Interfaces\CustomersRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use App\Domains\Customers\Exceptions\EmailIsAlreadyUsedException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

Class CustomersService{

    private $customers_respository;
    private $image_repository;

    public function __construct(CustomersRepositoryInterface $customers_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->customers_respository = $customers_respository;
        $this->image_repository = $image_repository;
       
	}

    public function update($id,$request){

       
        $data_model = $this->request_to_data_model($request);
        if($request->password){
            $data_model['password'] = \Hash::make($request->password);
        }
        $customer = $this->customers_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($customer , "customer","customer",$request->image);
        }
        return $customer;
    }

    public function get_instance(){
        return $this->customers_respository->get_instance();
    }
    public function countries(){
        return $this->customers_respository->countries();
    }

    public function prepare_data_table(){
        return $this->customers_respository->prepare_data_table();
    }

    public function all(){
        return $this->customers_respository->all();
    }

    public function find($id){
        return $this->customers_respository->find($id);
    }

    public function delete($id){
        $this->customers_respository->delete($id);
    }

    public function createFromBillingAddress($billing_address){
        //validate email address
        if (isEmailUnique($billing_address['email'])) {
            $data_model = $this->billing_address_to_data_model($billing_address);
        }else{
            throw new EmailIsAlreadyUsedException("Email address is already used");
        }
        
        if(isset($billing_address['password'])){
            $data_model['password'] = \Hash::make($billing_address['password']);
        }else{
            $data_model['password'] = \Hash::make(Str::random(40));
        }
        $customer = $this->customers_respository->create($data_model);
        return $customer;
    }

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        if($request->password){
            $data_model['password'] = \Hash::make($request->password);
        }else{
            $data_model['password'] = \Hash::make(Str::random(40));
        }
        $customer = $this->customers_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $customer, "customer","customer");
        }
        return $customer;

    }

    private function request_to_data_model($request){
       
            return 
            [
            'full_name'=> $request->full_name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'gender'=> $request->gender,
            'birth_date'=> $request->birth_date,
            'country_id'=> $request->country_id,
            'area'=> $request->area,
        ];
    }

    private function billing_address_to_data_model($billing_address){
        return 
        [
        'full_name'=> $billing_address['first_name'] . ' ' . $billing_address['last_name'],
        'email'=> $billing_address['email'],
        'phone'=> $billing_address['phone'],
        'gender'=> 'male',
        'birth_date'=>  Carbon::create(1994, 4, 13)->format('Y-m-d'),
        'country_id'=> $billing_address['country_id'],
        'area'=> $billing_address['state'],
    ];
}

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            'full_name'=> $entity->full_name,
            'email'=> $entity->email,
            'phone'=> $entity->phone,
            'gender'=> $entity->gender,
            'birth_date'=> $entity->birth_date,
            'country_id'=> $entity->country_id,
            'area'=> $entity->area,
            'password'=> $entity->password,
            "image" => $entity->images->where('field','customer')->first(),
        ];
    }

    public function findCustomerByNameOrPhone($term){
        return $this->customers_respository->findCustomerByNameOrPhone($term);
    }
   
}
