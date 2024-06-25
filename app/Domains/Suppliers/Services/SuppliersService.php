<?php

namespace App\Domains\Suppliers\Services;

use App\Domains\Suppliers\Interfaces\SuppliersRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;

Class SuppliersService{


    private $suppliers_respository;
    private $image_repository;

    public function __construct(SuppliersRepositoryInterface $suppliers_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->suppliers_respository = $suppliers_respository;
        $this->image_repository = $image_repository;
       
	}

   
    public function update($id,$request){
       
        $data_model = $this->request_to_data_model($request);
        $supplier = $this->suppliers_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($supplier , "supplier","supplier",$request->image);
        }
        return $supplier;
    }

    public function get_instance(){
        return $this->suppliers_respository->get_instance();
    }
    public function countries(){
        return $this->suppliers_respository->countries();
    }

    public function prepare_data_table(){
        return $this->suppliers_respository->prepare_data_table();
    }

    public function all(){
        return $this->suppliers_respository->all();
    }

    public function find($id){
        return $this->suppliers_respository->find($id);
    }

    public function delete($id){
        $this->suppliers_respository->delete($id);
    }
    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $supplier = $this->suppliers_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $supplier, "supplier","supplier");
        }
        return $supplier;

    }

    private function request_to_data_model($request){
       
        $data_model =  
        [
            'full_name'=> $request->full_name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'area'=> $request->area,
            'country_id'=> $request->country_id,
        ];

        return $data_model;
        
    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            'full_name'=> $entity->full_name,
            'email'=> $entity->email,
            'phone'=> $entity->phone,
            'area'=> $entity->area,
            'country_id'=> $entity->country_id,
            "image" => $entity->images->where('field','supplier')->first(),
        ];
    }
   
}
