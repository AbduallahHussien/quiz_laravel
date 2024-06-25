<?php

namespace App\Domains\Assets\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Assets\Entities\AssetCategory;
use App\Domains\Assets\Interfaces\AssetCategoryRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  AssetCategoryRepository extends BaseRepository implements AssetCategoryRepositoryInterface
{

    /**
    * AddonsRepository constructor.
    *
    * @param AssetCategory $model
    */
    public function __construct(AssetCategory $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("select
                                asset_categories.id,
                                asset_categories.name ,
                                asset_categories.name_ar ,
                                asset_categories.created_at,
                                count(assets.id) as assets_count
                            from
                                asset_categories
                            left join assets on
                                asset_categories.id = assets.category_id
                            group by
                                asset_categories.id,
                                asset_categories.name,
                                asset_categories.created_at");
    }
  
    
    
  


}
