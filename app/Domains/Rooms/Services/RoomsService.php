<?php

namespace App\Domains\Rooms\Services;

use App\Domains\Rooms\Interfaces\RoomsRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;

Class RoomsService{


    private $rooms_respository;
    private $image_repository;

    public function __construct(RoomsRepositoryInterface $rooms_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->rooms_respository = $rooms_respository;
        $this->image_repository = $image_repository;
       
	}

   
    public function update($id,$request){

        $data_model = $this->request_to_data_model($request);
        $room = $this->rooms_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($room , "room","room",$request->image);
        }
        return $room;
    }

    public function get_instance(){
        return $this->rooms_respository->get_instance();
    }
    public function countries(){
        return $this->rooms_respository->countries();
    }

    public function prepare_data_table(){
        return $this->rooms_respository->prepare_data_table();
    }

    public function all(){
        return $this->rooms_respository->all();
    }

    public function find($id){
        return $this->rooms_respository->find($id);
    }

    public function delete($id){
        $this->rooms_respository->delete($id);
    }
    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $room = $this->rooms_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $room, "room","room");
        }
        return $room;

    }

    private function request_to_data_model($request){
       
        return 
        [
            'name'=> $request->name,
            'description'=> $request->description,            
            'name_ar'=> $request->name_ar,
            'description_ar'=> $request->description_ar,
        ];
    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            'name'=> $entity->name,
            'description'=> $entity->description,            
            'name_ar'=> $entity->name_ar,
            'description_ar'=> $entity->description_ar,
            "image" => $entity->images->where('field','room')->first(),
        ];
    }

    public function findRoomsByName($term){
        return $this->rooms_respository->findRoomsByName($term);
    }
   
}
