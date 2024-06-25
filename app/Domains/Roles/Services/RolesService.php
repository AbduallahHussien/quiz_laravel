<?php

namespace App\Domains\Roles\Services;

use App\Domains\Roles\Interfaces\RolesRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

Class RolesService{

    private $roles_respository;

    public function __construct(RolesRepositoryInterface $roles_respository)
	{
        $this->roles_respository = $roles_respository;
       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $roles = $this->roles_respository->create($data_model);
        return $roles;

    }
    
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $roles = $this->roles_respository->update($id,$data_model);
        return $roles;
    }

    public function get_instance(){
        return $this->roles_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->roles_respository->prepare_data_table();
    }

    public function all(){
        return $this->roles_respository->all();
    }

    public function find($id){
        return $this->roles_respository->find($id);
    }

    public function delete($id){
        $this->roles_respository->delete($id);
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
