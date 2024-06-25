<?php

namespace App\Domains\Categories\Services;

use App\Domains\Categories\Interfaces\CategoriesRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class CategoriesService{

    private $categories_respository;
    private $image_repository;

    public function __construct(CategoriesRepositoryInterface $categories_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->categories_respository = $categories_respository;
        $this->image_repository = $image_repository;
       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $slug = $this->generateUniqueSlug('',$request->slug,'categories','slug');
        $data_model['slug'] = $slug;
        $categories = $this->categories_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $categories, "logo","logo");
        }
        return $categories;

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
        $slug = $this->generateUniqueSlug($id,$request->slug,'categories','slug');
        $data_model['slug'] = $slug;
        $categories = $this->categories_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($categories , "logo","logo",$request->image);
        }
        return $categories;
    }

    public function get_instance(){
        return $this->categories_respository->get_instance();
    }

    public function prepare_data_table($type){
        return $this->categories_respository->prepare_data_table($type);
    }

    public function all(){
        return $this->categories_respository->all();
    }

    public function all_by_type($type){
        return $this->categories_respository->all_by_type($type);
    }
    

    public function findCategoryBySlug($slug){
        return $this->categories_respository->findCategoryBySlug($slug);
    }

    public function SidebarCategories(){
        return $this->categories_respository->SidebarCategories();
    }
    
    

   

    public function find($id){
        return $this->categories_respository->find($id);
    }

    public function delete($id){
        $this->categories_respository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                "name" => $request->name,
                "name_ar" => $request->name_ar,
                "slug" => $request->slug,
                "parent_id" => $request->parent_id,
                "description_ar" => $request->description_ar,
                "type" => $request->type,
            ];
      

    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "name" => $entity->name,
            "name_ar" => $entity->name_ar,
            "slug" => $entity->slug,
            "parent_id" => $entity->parent_id,
            "description" => $entity->description,
            "description_ar" => $entity->description_ar,
            "type" => $entity->type,
            "image" => $entity->images->where('field','logo')->first(),
        ];
    }
   
}
