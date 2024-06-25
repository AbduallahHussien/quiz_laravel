<?php

namespace App\Domains\Addons\Services;

use App\Domains\Addons\Interfaces\AddonsRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class AddonsService{

    private $addons_respository;
    private $image_repository;

    public function __construct(AddonsRepositoryInterface $addons_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->addons_respository = $addons_respository;
        $this->image_repository = $image_repository;
       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
       
        $addons = $this->addons_respository->create($data_model);

        return $addons;

    }
 
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
      
        $addons = $this->addons_respository->update($id,$data_model);
      
        return $addons;
    }

    public function get_instance(){
        return $this->addons_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->addons_respository->prepare_data_table();
    }

    public function all(){
        return $this->addons_respository->all();
    }

    public function find($id){
        return $this->addons_respository->find($id);
    }

    public function delete($id){
        $this->addons_respository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                "name" => $request->name,
                "name_ar" => $request->name_ar,
            ];
      

    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "name" => $entity->name,
            "name_ar" => $entity->name_ar,
        
        ];
    }
   
}
