<?php

namespace App\Domains\Pages\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Pages\Entities\Pages;
use App\Domains\Pages\Interfaces\PagesRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  PagesRepository extends BaseRepository implements PagesRepositoryInterface
{

    /**
    * PagesRepository constructor.
    *
    * @param Pages $model
    */
    public function __construct(Pages $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT pages.*
                           FROM   pages
                           order by pages.id ASC
                        ");
    }

    public function findPageBySlug($slug){
        return $this->model::where('slug',$slug)->first();
    }
    
  
    
    
  


}
