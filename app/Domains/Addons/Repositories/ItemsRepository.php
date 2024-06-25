<?php

namespace App\Domains\Addons\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Addons\Entities\Items;
use App\Domains\Addons\Interfaces\ItemsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  ItemsRepository extends BaseRepository implements ItemsRepositoryInterface
{

    /**
    * ItemsRepository constructor.
    *
    * @param Items $model
    */
    public function __construct(Items $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table($id){

        return DB::select("SELECT addons_items.*, addons.name as category , locations.name as location from addons_items
                                LEFT JOIN addons
                                    ON addons_items.addon_id = addons.id
                                LEFT JOIN locations
                                    ON addons_items.location_id = locations.id
                                        LEFT JOIN images
                                            ON addons_items.id = images.imageable_id
                                            AND images.field = 'logo' 
                                            AND images.imageable_type like'%Items%'
                                            where  addons_items.addon_id = $id
                                            order by addons_items.id ASC

        ");
        
    }

    public function findIemsByNameOrBarcode($term, $location_id = null){
        $filter_by_locatoin_query = "";
        $quatity_selector = "";
        if($location_id){
            $filter_by_locatoin_query = "
            inner join locations_addons_items 
            on addons_items.id = locations_addons_items.addons_item_id  
            and locations_addons_items.location_id = $location_id 
            and locations_addons_items.quantity > 0
            ";

            $quatity_selector = ", locations_addons_items.quantity";
        }
        return DB::select("select
                                addons_items.id,
                                addons_items.name,
                                addons_items.price,
                                addons_items.price_euro
                                $quatity_selector
                                
                            from
                                addons_items
                            $filter_by_locatoin_query
                            where
                                name like '%$term%'
                                or barcode like '$term'");
    }
    
    
      public function getTransferItem($item_id, $location_id){

        $data =  DB::select("select
                            li.id,
                            ai.name,
                            li.addons_item_id as item_id,
                            li.quantity
                        from
                            locations_addons_itemss li
                        inner join addons_items ai on
                            li.addons_item_id = ai.id
                        where
                            li.location_id = $location_id
                            and
                            li.addons_item_id = $item_id
                            ");
        return count($data) ? (object) $data[0]:false; 
    }
  


}
