<?php

namespace App\Domains\Vendors\Services;

use App\Domains\Vendors\Interfaces\VendorsRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;

Class VendorsService{


    private $vendors_respository;
    private $image_repository;

    public function __construct(VendorsRepositoryInterface $vendors_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->vendors_respository = $vendors_respository;
        $this->image_repository = $image_repository;
       
	}

   
    public function update($id,$request){
       
        $data_model = $this->request_to_data_model($request);
        if($request->password){
            $data_model['password'] = \Hash::make($request->password);
        }

        if ($request->national_id_front) {
            $data_model['national_id_front'] = $this->image_repository->imageUpload($request->national_id_front);
        }
        
        if ($request->national_id_back) {
            $data_model['national_id_back'] = $this->image_repository->imageUpload($request->national_id_back);
        }

        
        if ($request->status_card_front) {
            $data_model['status_card_front'] = $this->image_repository->imageUpload($request->status_card_front);
        }        
        
        if ($request->status_card_back) {
            $data_model['status_card_back'] = $this->image_repository->imageUpload($request->status_card_back);
        }        

        if ($request->iban_letter) {
            $data_model['iban_letter'] = $this->image_repository->imageUpload($request->iban_letter);
        }

        $vendor = $this->vendors_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($vendor , "vendor","vendor",$request->image);
        }
        return $vendor;
    }

    public function get_instance(){
        return $this->vendors_respository->get_instance();
    }
    public function countries(){
        return $this->vendors_respository->countries();
    }

    public function prepare_data_table(){
        return $this->vendors_respository->prepare_data_table();
    }

    public function all(){
        return $this->vendors_respository->all();
    }

    public function find($id){
        return $this->vendors_respository->find($id);
    }

    public function delete($id){
        $this->vendors_respository->delete($id);
    }
    public function create($request){

        $data_model = $this->request_to_data_model($request);
        if($request->password){
            $data_model['password'] = \Hash::make($request->password);
        }else{
            $data_model['password'] = \Hash::make(\Str::random(40));
        }

        if ($request->national_id_front) {
            $data_model['national_id_front'] = $this->image_repository->imageUpload($request->national_id_front);
        }
        
        if ($request->national_id_back) {
            $data_model['national_id_back'] = $this->image_repository->imageUpload($request->national_id_back);
        }

        
        if ($request->status_card_front) {
            $data_model['status_card_front'] = $this->image_repository->imageUpload($request->status_card_front);
        }        
        
        if ($request->status_card_back) {
            $data_model['status_card_back'] = $this->image_repository->imageUpload($request->status_card_back);
        }        

        if ($request->iban_letter) {
            $data_model['iban_letter'] = $this->image_repository->imageUpload($request->iban_letter);
        }
        
        $vendor = $this->vendors_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $vendor, "vendor","vendor");
        }        
        return $vendor;

    }

    private function request_to_data_model($request){
       
        $data_model =  
        [
            'full_name'=> $request->full_name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'area'=> $request->area,
            'country_id'=> $request->country_id,
            'national_address'=> $request->national_address,
        ];

        if($request->has('status')){
            $data_model['status'] = $request->status;
        }


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
            'status'=> $entity->status,
            "image" => $entity->images->where('field','vendor')->first(),
            'national_id_front' => $entity->national_id_front,
            'national_id_back' => $entity->national_id_back,
            'status_card_front' => $entity->status_card_front,
            'status_card_back' => $entity->status_card_back,
            'iban_letter'  => $entity->iban_letter,
            'national_address' => $entity->national_address,
        ];
    }
   
}
