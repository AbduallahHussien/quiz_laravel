<?php

namespace App\Domains\Coupons\Services;

use App\Domains\Coupons\Exceptions\CouponCodeAlreadyExistsException;
use App\Domains\Coupons\Exceptions\CouponNotFoundException;
use App\Domains\Coupons\Interfaces\CouponsRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class CouponsService{

    private $coupons_respository;

    public function __construct(CouponsRepositoryInterface $coupons_respository)
	{
        $this->coupons_respository = $coupons_respository;
       
	}

 
    public function create($request)
    {
        
        $data_model = $this->request_to_data_model($request);
        // Check if coupon code already exists or not
        $coupon_exists = $this->coupons_respository->checkIfCouponExists($data_model['code']);
    
        if ($coupon_exists) {
            throw new CouponCodeAlreadyExistsException('Coupon code already exists.');
        }
    
        return $this->coupons_respository->create($data_model);
    }
    
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $coupon = $this->coupons_respository->update($id,$data_model);
        return $coupon;
    }




    public function get_instance(){
        return $this->coupons_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->coupons_respository->prepare_data_table();
    }

    public function all(){
        return $this->coupons_respository->all();
    }

    public function find($id){
        return $this->coupons_respository->find($id);
    }

    public function delete($id){
        $this->coupons_respository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                "code" => $request->code,
                "discount" => $request->discount,
                "expires_at" => $request->expires_at,
            ];
      

    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "code" => $entity->code,
            "discount" => $entity->discount,
            "expires_at" => $entity->expires_at,
        ];
    }

    public function getCouponDiscount($coupon_code){
        $coupon = $this->coupons_respository->findAvailableCouponByCode($coupon_code);
        if(!$coupon){
            throw new CouponNotFoundException("Coupon doesn't exist");
        }
        return $coupon->discount;
    }

    public function markCouponAsUsedByCode($coupon_code){
       $this->coupons_respository->markCouponAsUsedByCode($coupon_code);

    }

}
