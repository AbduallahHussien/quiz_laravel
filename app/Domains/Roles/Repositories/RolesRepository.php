<?php

namespace App\Domains\Roles\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Roles\Entities\Roles;
use App\Domains\Roles\Interfaces\RolesRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  RolesRepository extends BaseRepository implements RolesRepositoryInterface
{

    /**
    * RolesRepository constructor.
    *
    * @param Roles $model
    */
    public function __construct(Roles $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT settings.*,
        images.file as logo
        FROM   settings
            LEFT JOIN images
                ON settings.id = images.imageable_id
                AND images.field = 'logo' 
                 AND images.imageable_type like'%settings%'
                 order by settings.id ASC");
    }
  
    
    
  


}
