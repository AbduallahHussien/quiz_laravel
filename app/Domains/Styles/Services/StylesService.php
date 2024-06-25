<?php

namespace App\Domains\Styles\Services;

use App\Domains\Styles\Interfaces\StylesRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class StylesService{

    private $styles_respository;
    private $image_repository;

    public function __construct(StylesRepositoryInterface $styles_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->styles_respository = $styles_respository;
        $this->image_repository = $image_repository;
       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $slug = $this->generateUniqueSlug('',$request->slug,'styles','slug');
        $data_model['slug'] = $slug;
        $styles = $this->styles_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $styles, "logo","logo");
        }
        return $styles;

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
        $slug = $this->generateUniqueSlug($id,$request->slug,'styles','slug');
        $data_model['slug'] = $slug;
        $styles = $this->styles_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($styles , "logo","logo",$request->image);
        }
        return $styles;
    }

    public function get_instance(){
        return $this->styles_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->styles_respository->prepare_data_table();
    }

    public function all(){
        return $this->styles_respository->all();
    }

    public function find($id){
        return $this->styles_respository->find($id);
    }

    public function delete($id){
        $this->styles_respository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                "name" => $request->name,
                "name_ar" => $request->name_ar,
                "slug" => $request->slug,
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
            "description" => $entity->description,
            "description_ar" => $entity->description_ar,
            "image" => $entity->images->where('field','logo')->first(),


        ];
    }
   
}
