<?php

namespace App\Domains\Courses\Services;

use App\Domains\Courses\Interfaces\CourseRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class CourseService{

    private $course_repository;
    private $image_repository;

    public function __construct(
        CourseRepositoryInterface $course_repository,
        ImageRepositoryInterface $image_repository,
    )
	{
        $this->course_repository = $course_repository;
        $this->image_repository = $image_repository;       
	}

    public function create($request){
        $data_model = $this->request_to_data_model($request);
        $slug = $this->generateUniqueSlug('',$request->slug,'courses','slug');
        $data_model['slug'] = $slug;
        $course = $this->course_repository->create($data_model);
        if ($request->image) {
            $this->course_repository->upload($request->image, $course, "logo","logo");
        }
        return $course;
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
        $slug = $this->generateUniqueSlug($id,$request->slug,'courses','slug');
        $data_model['slug'] = $slug;
        $course = $this->course_repository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($items , "logo","logo",$request->image);
        }
        return $course;
    }
    public function get_instance(){
        return $this->course_repository->get_instance();
    }

    public function prepare_data_table($id){
        return $this->course_repository->prepare_data_table($id);
    }

    public function all(){
        return $this->course_repository->all();
    }

    public function find($id){
        return $this->course_repository->find($id);
    }

    public function findCoursesByName($term){
        return $this->course_repository->findCoursesByName($term);
    }

    public function delete($id){
        $course = $this->find($id);
        $this->course_repository->delete($id);
    }
    

    private function request_to_data_model($request){
       
            $data =  [
                "title" => $request->title,
                "title_ar" => $request->title_ar,
                'slug'=> $request->slug,
                'category_id'=> $request->category_id,
                'description'=> $request->description,
                'description_ar'=> $request->description_ar,
            ];
            return $data;
    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "title" => $entity->title,
            "title_ar" => $entity->title_ar,
            'slug'=> $entity->slug,
            'category_id'=> $entity->category_id,
            'description'=> $entity->description,
            'description_ar'=> $entity->description_ar,
            "image" => $entity->images->where('field','logo')->first(),
        ];
    }
   
}
