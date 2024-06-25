<?php

namespace App\Domains\Addons\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Addons\Entities\Addons;
use App\Domains\Addons\Interfaces\AddonsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  AddonsRepository extends BaseRepository implements AddonsRepositoryInterface
{

    /**
    * AddonsRepository constructor.
    *
    * @param Addons $model
    */
    public function __construct(Addons $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT addons.* from addons");
    }
  
    
    
  


}
