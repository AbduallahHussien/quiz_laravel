<?php

namespace App\Domains\Coupons\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Coupons\Entities\Coupons;
use App\Domains\Coupons\Interfaces\CouponsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  CouponsRepository extends BaseRepository implements CouponsRepositoryInterface
{

    /**
    * CouponsRepository constructor.
    *
    * @param Coupons $model
    */
    public function __construct(Coupons $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT coupons.*
        FROM   coupons
                 order by coupons.id ASC
                 ");
    }

    public function checkIfCouponExists($code,$coupon_id = null){
        $query = $this->model::where('code', $code);

        if ($coupon_id !== null) {
            $query->where('id', '!=', $coupon_id);
        }
    
        return $query->exists();
    }

    public function findAvailableCouponByCode($coupon_code){
        return $this->model::where('code', $coupon_code)
        ->where('used', false)
        ->where('expires_at', '>', now())->first();
    }

    public function markCouponAsUsedByCode($coupon_code){
        $this->model::where('code', $coupon_code)->update(['used' => true]);
    }
    
}
