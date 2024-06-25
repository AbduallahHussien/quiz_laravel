<?php

namespace App\Domains\Colors\Services;

use App\Domains\Colors\Interfaces\ColorsRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class ColorsService{

    private $colors_respository;
    private $image_repository;

    public function __construct(ColorsRepositoryInterface $colors_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->colors_respository = $colors_respository;
        $this->image_repository = $image_repository;
       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $slug = $this->generateUniqueSlug('',$request->slug,'colors','slug');
        $data_model['slug'] = $slug;
        $colors = $this->colors_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $colors, "logo","logo");
        }
        return $colors;

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
        $slug = $this->generateUniqueSlug($id,$request->slug,'colors','slug');
        $data_model['slug'] = $slug;
        $colors = $this->colors_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($colors , "logo","logo",$request->image);
        }
        return $colors;
    }

    public function get_instance(){
        return $this->colors_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->colors_respository->prepare_data_table();
    }

    public function all(){
        return $this->colors_respository->all();
    }

    public function find($id){
        return $this->colors_respository->find($id);
    }

    public function delete($id){
        $this->colors_respository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                "name" => $request->name,
                "name_ar" => $request->name_ar,
                "slug" => $request->slug,
                "hexa" => $request->hexa,
                "description" => $request->description,
                "description_ar" => $request->description_ar,
               
            ];
      

    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "name" => $entity->name,
            "name_ar" => $entity->name_ar,
            "slug" => $entity->slug,
            "hexa" => $entity->hexa,
            "description" => $entity->description,
            "description_ar" => $entity->description_ar,
            "image" => $entity->images->where('field','logo')->first(),


        ];
    }
   
}
