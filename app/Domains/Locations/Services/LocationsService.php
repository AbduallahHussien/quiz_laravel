<?php

namespace App\Domains\Locations\Services;

use App\Domains\Locations\Interfaces\LocationsRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class LocationsService{

    private $locations_respository;
    private $image_repository;

    public function __construct(LocationsRepositoryInterface $locations_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->locations_respository = $locations_respository;
        $this->image_repository = $image_repository;
       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $locations = $this->locations_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $locations, "logo","logo");
        }
        return $locations;

    }
    
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $locations = $this->locations_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($locations , "logo","logo",$request->image);
        }
        return $locations;
    }

    public function get_instance(){
        return $this->locations_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->locations_respository->prepare_data_table();
    }

    public function prepare_stock_data_table($id){
        return $this->locations_respository->prepare_stock_data_table($id);
    }

    public function allWithout($excludedIds){
        return $this->locations_respository->allWithout($excludedIds);
    }

    public function all(){
        return $this->locations_respository->all();
    }

    public function find($id){
        return $this->locations_respository->find($id);
    }

    public function delete($id){
        $this->locations_respository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                "name" => $request->name,
                "name_ar" => $request->name_ar,
                "city_id" => $request->city_id,
                "country_id" => $request->country_id,
                "area" => $request->area,
                "address" => $request->address,
                "address_ar" => $request->address_ar,
                "columns" => $request->columns,
                "rows" => $request->rows,
            ];
      

    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "name" => $entity->name,
            "name_ar" => $entity->name_ar,
            "city_id" => $entity->city_id,
            "country_id" => $entity->country_id,
            "area" => $entity->area,
            "address" => $entity->address,
            "address_ar" => $entity->address_ar,
            "columns" => $entity->columns,
            "rows" => $entity->rows,
            "image" => $entity->images->where('field','logo')->first(),


        ];
    }


    public function allCitiesByCountry($id){
        return $this->locations_respository->allCitiesByCountry($id);
    }

    public function countries(){
        return $this->locations_respository->countries();
    }
    public function cities(){
        return $this->locations_respository->cities();
    }

    public function quantity_to_store($location_id, $item_id, $quantity){
        return $this->locations_respository->quantity_to_store($location_id, $item_id, $quantity);
    }
   
}
