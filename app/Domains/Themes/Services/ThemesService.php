<?php

namespace App\Domains\Themes\Services;

use App\Domains\Themes\Interfaces\ThemesRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class ThemesService{

    private $themes_respository;
    private $image_repository;

    public function __construct(ThemesRepositoryInterface $themes_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->themes_respository = $themes_respository;
        $this->image_repository = $image_repository;
       
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

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $slug = $this->generateUniqueSlug('',$request->slug,'themes','slug');
        $data_model['slug'] = $slug;
        $themes = $this->themes_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $themes, "logo","logo");
        }
        return $themes;

    }
    
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $slug = $this->generateUniqueSlug($id,$request->slug,'themes','slug');
        $data_model['slug'] = $slug;
        $themes = $this->themes_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($themes , "logo","logo",$request->image);
        }
        return $themes;
    }

    public function get_instance(){
        return $this->themes_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->themes_respository->prepare_data_table();
    }

    public function all(){
        return $this->themes_respository->all();
    }

    public function find($id){
        return $this->themes_respository->find($id);
    }

    public function delete($id){
        $this->themes_respository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                "name" => $request->name,
                "slug" => $request->slug,
                "description" => $request->description,
                "name_ar" => $request->name_ar,
                "description_ar" => $request->description_ar,
               
            ];
      

    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "name" => $entity->name,
            "slug" => $entity->slug,
            "description" => $entity->description,
            "name_ar" => $entity->name_ar,
            "description_ar" => $entity->description_ar,
            "image" => $entity->images->where('field','logo')->first(),


        ];
    }
   
}
