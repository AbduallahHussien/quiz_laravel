<?php

namespace App\Domains\Themes\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Themes\Entities\Themes;
use App\Domains\Themes\Interfaces\ThemesRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  ThemesRepository extends BaseRepository implements ThemesRepositoryInterface
{

    /**
    * ThemesRepository constructor.
    *
    * @param Themes $model
    */
    public function __construct(Themes $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT themes.*,
        images.file as logo
        FROM   themes
            LEFT JOIN images
                ON themes.id = images.imageable_id
                AND images.field = 'logo' 
                 AND images.imageable_type like'%themes%'
                 order by themes.id ASC
                 ");
    }
  
    
    
  


}
