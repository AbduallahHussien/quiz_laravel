<?php

namespace App\Domains\Styles\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Styles\Entities\Styles;
use App\Domains\Styles\Interfaces\StylesRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  StylesRepository extends BaseRepository implements StylesRepositoryInterface
{

    /**
    * StylesRepository constructor.
    *
    * @param Styles $model
    */
    public function __construct(Styles $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT styles.*,
        images.file as logo
        FROM   styles
            LEFT JOIN images
                ON styles.id = images.imageable_id
                AND images.field = 'logo' 
                 AND images.imageable_type like'%styles%'
                 order by styles.id ASC
                 ");
    }
  
    
    
  


}
