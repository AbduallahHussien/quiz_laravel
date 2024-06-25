<?php

namespace App\Domains\Locations\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Locations\Entities\Locations;
use App\Domains\Locations\Entities\LocationAddonItem;
use App\Domains\Locations\Interfaces\LocationsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  LocationsRepository extends BaseRepository implements LocationsRepositoryInterface
{

    /**
    * LocationsRepository constructor.
    *
    * @param Locations $model
    */
    public function __construct(Locations $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT locations.*, countries.name as country , cities.name as city,
        images.file as logo
        FROM   locations
            LEFT JOIN countries on locations.country_id = countries.id
            LEFT JOIN cities on locations.city_id = cities.id
            LEFT JOIN images
                ON locations.id = images.imageable_id
                AND images.field = 'logo' 
                 AND images.imageable_type like'%locations%'
                 order by locations.id ASC
                 ");
    }
    
    
    public function prepare_stock_data_table($id){

        return DB::select("select
                                li.id,
                                ai.name,
                                li.addons_item_id as item_id,
                                li.quantity
                            from
                                locations_addons_items li
                            inner join addons_items ai on
                                li.addons_item_id = ai.id
                            where
                                li.location_id = $id
                            order by li.quantity desc
                            ");
    }


    public function countries(){
        return DB::table('countries')->get();
    }

    public function cities(){
        return DB::table('cities')->get();
    }

    public function allCitiesByCountry($id)
    {
        return DB::table('cities')
            ->select('cities.*')
            ->where('cities.country_id', $id)
            ->get();
    }
    
    public function quantity_to_store($location_id, $item_id, $quantity){
        $item = LocationAddonItem::firstOrCreate([
            'location_id' => $location_id,
            'addons_item_id' => $item_id,
        ])->increment('quantity', $quantity);
    }

    public function allWithout($excludedIds){
        return $this->model::whereNotIn('id', $excludedIds)->get();
    }



}
