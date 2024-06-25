<?php

namespace App\Domains\Colors\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Colors\Entities\Colors;
use App\Domains\Colors\Interfaces\ColorsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  ColorsRepository extends BaseRepository implements ColorsRepositoryInterface
{

    /**
    * ColorsRepository constructor.
    *
    * @param Colors $model
    */
    public function __construct(Colors $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT colors.*,
        images.file as logo
        FROM   colors
            LEFT JOIN images
                ON colors.id = images.imageable_id
                AND images.field = 'logo' 
                 AND images.imageable_type like'%colors%'
                 order by colors.id ASC
                 ");
    }
  
    
    
  


}
