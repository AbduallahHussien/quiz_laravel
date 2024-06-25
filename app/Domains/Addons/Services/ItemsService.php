<?php

namespace App\Domains\Addons\Services;

use App\Domains\Addons\Interfaces\ItemsRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use App\Domains\Locations\Services\LocationsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class ItemsService{

    private $items_respository;
    private $image_repository;
    private $location_service;

    public function __construct(
        ItemsRepositoryInterface $items_respository,
        ImageRepositoryInterface $image_repository,
        LocationsService $location_service,
    )
	{
        $this->items_respository = $items_respository;
        $this->image_repository = $image_repository;
        $this->location_service = $location_service;
       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $slug = $this->generateUniqueSlug('',$request->slug,'addons_items','slug');
        $data_model['slug'] = $slug;
        $items = $this->items_respository->create($data_model);
        $this->location_service->quantity_to_store($items->location_id, $items->id, $items->quantity);
        if ($request->image) {
            $this->image_repository->upload($request->image, $items, "logo","logo");
        }
        return $items;

    }

    public function generateUniqueSlug($id,$name, $table, $column ) {
        $slug = Str::slug($name);
        $count = 1;
        $originalSlug = $slug;
        if($id){
            if (DB::table($table)->where($column, $slug)->where('id', $id)->exists()) {
                return $slug;   
            }else{
                while (DB::table($table)->where($column, $slug)->exists()) {
                    $slug = $originalSlug . '-' . Str::random(5); // Add a random 5-character string
                    $count++;
                }
            }
        }else{
                 while (DB::table($table)->where($column, $slug)->exists()) {
                            $slug = $originalSlug . '-' . Str::random(5); // Add a random 5-character string
                            $count++;
                        }
        }
        
        
        return $slug;
        
    }
   
    
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $slug = $this->generateUniqueSlug($id,$request->slug,'addons_items','slug');
        $data_model['slug'] = $slug;
        $items = $this->items_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($items , "logo","logo",$request->image);
        }
        return $items;
    }
    public function get_instance(){
        return $this->items_respository->get_instance();
    }

    public function prepare_data_table($id){
        return $this->items_respository->prepare_data_table($id);
    }

    public function all(){
        return $this->items_respository->all();
    }

    public function find($id){
        return $this->items_respository->find($id);
    }

    public function findIemsByNameOrBarcode($term, $location_id = null){
        return $this->items_respository->findIemsByNameOrBarcode($term, $location_id);
    }
    
    public function getTransferItem($item_id, $location_id){
        return $this->items_respository->getTransferItem($item_id, $location_id);
    }

    public function delete($id){
        $item = $this->find($id);
        $this->items_respository->delete($id);
    }
    

    private function request_to_data_model($request){
       
            $data =  [
                "name" => $request->name,
                "name_ar" => $request->name_ar,
                'slug'=> $request->slug,
                'addon_id'=> $request->addon_id,
                'description'=> $request->description,
                'description_ar'=> $request->description_ar,
                'price'=> $request->price,
                'price_euro'=> $request->price_euro,
                'barcode' => $request->barcode,
                'barcode_secondary' => $request->barcode_secondary,
            ];

            if($request->location_id){
                $data['location_id'] = $request->location_id;
            }
            
            if($request->has('quantity')){
                $data['quantity'] = $request->quantity;
            }

            return $data;
    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "name" => $entity->name,
            "name_ar" => $entity->name_ar,
            'slug'=> $entity->slug,
            'addon_id'=> $entity->addon_id,
            'location_id'=> $entity->location_id,
            'description'=> $entity->description,
            'description_ar'=> $entity->description_ar,
            'category_id'=> $entity->addon_id,
            'price'=> $entity->price,
            'price_euro'=> $entity->price_euro,
            'quantity'=> $entity->quantity,
            'barcode' => $entity->barcode,
            'barcode_secondary' => $entity->barcode_secondary,
            "image" => $entity->images->where('field','logo')->first(),
            
        
        ];
    }
   
}
