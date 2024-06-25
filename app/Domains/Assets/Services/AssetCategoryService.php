<?php

namespace App\Domains\Assets\Services;

use App\Domains\Assets\Interfaces\AssetCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class AssetCategoryService{

    private $asset_category_respository;
    private $image_repository;

    public function __construct(AssetCategoryRepositoryInterface $asset_category_respository)
	{
        $this->asset_category_respository = $asset_category_respository;       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
       
        $asset_category = $this->asset_category_respository->create($data_model);

        return $asset_category;

    }
 
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
      
        $asset_category = $this->asset_category_respository->update($id,$data_model);
      
        return $asset_category;
    }

    public function get_instance(){
        return $this->asset_category_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->asset_category_respository->prepare_data_table();
    }

    public function all(){
        return $this->asset_category_respository->all();
    }

    public function find($id){
        return $this->asset_category_respository->find($id);
    }

    public function delete($id){
        $this->asset_category_respository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                "name" => $request->name,
                "description" => $request->description,                
                "name_ar" => $request->name_ar,
                "description_ar" => $request->description_ar,
            ];
      

    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "name" => $entity->name,
            "description" => $entity->description,            
            "name_ar" => $entity->name_ar,
            "description_ar" => $entity->description_ar,
        ];
    }
   
}
