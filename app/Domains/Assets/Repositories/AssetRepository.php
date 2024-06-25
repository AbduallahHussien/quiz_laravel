<?php

namespace App\Domains\Assets\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Assets\Entities\Asset;
use App\Domains\Assets\Entities\AssetUser;
use App\Domains\Assets\Interfaces\AssetRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  AssetRepository extends BaseRepository implements AssetRepositoryInterface
{

    /**
    * AssetRepository constructor.
    *
    * @param Asset $model
    */
    public function __construct(Asset $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table($id){

        return DB::select("SELECT assets.*, asset_categories.name as category  from assets
                                LEFT JOIN asset_categories
                                    ON assets.category_id = asset_categories.id
                                            where  assets.category_id = $id
                                            order by assets.id ASC

        ");
        
    }

    public function findAssetsByName($term){
        return DB::select("select
                                id,
                                title
                            from
                                assets
                            where
                                title like '%$term%'");
    }
    

    public function assign($asset_id, $owner_id, $quantity){
        $assigned_asset = AssetUser::firstOrCreate([
            'user_id' => $owner_id,
            'asset_id' => $asset_id,
        ])->increment('quantity', $quantity);
    }

    public function total_assigned($asset_id){
        return AssetUser::with(['users' => function ($query) {
            $query->where('asset_id', '=', $asset_id); 
        }])->sum('asset_user.quantity');
    }

    public function unassign($id){
        $record = AssetUser::find($id);
        $record->delete();
        return $record;
    }
    
  


}
