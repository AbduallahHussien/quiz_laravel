<?php

namespace App\Domains\Curd\Services;

use App\Domains\Curd\Interfaces\CurdRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

Class CurdService{

    private $curd_respository;

    public function __construct(CurdRepositoryInterface $curd_respository)
	{
        $this->curd_respository = $curd_respository;
       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $curd = $this->curd_respository->create($data_model);
        return $curd;

    }
    
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $curd = $this->curd_respository->update($id,$data_model);
        return $curd;
    }

    public function get_instance(){
        return $this->curd_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->curd_respository->prepare_data_table();
    }

    public function all(){
        return $this->curd_respository->all();
    }

    public function find($id){
        return $this->curd_respository->find($id);
    }

    public function delete($id){
        $this->curd_respository->delete($id);
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
