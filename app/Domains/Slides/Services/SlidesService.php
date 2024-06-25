<?php

namespace App\Domains\Slides\Services;

use App\Domains\Slides\Interfaces\SlidesRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class SlidesService{

    private $slides_respository;
    private $image_repository;

    public function __construct(SlidesRepositoryInterface $slides_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->slides_respository = $slides_respository;
        $this->image_repository = $image_repository;
       
	}

 
    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $slide = $this->slides_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $slide, "slide","slide");
        }
        
        return $slide;

    }
    
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $slide = $this->slides_respository->update($id,$data_model);
        
        if ($request->image) {
            $this->image_repository->update_field($slide , "slide","slide",$request->image);
        }

        return $slide;
    }




    public function get_instance(){
        return $this->slides_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->slides_respository->prepare_data_table();
    }

    public function all(){
        return $this->slides_respository->all();
    }

    public function find($id){
        return $this->slides_respository->find($id);
    }

    public function delete($id){
        $this->slides_respository->delete($id);
    }

    
    public function homeSlides(){
        return $this->slides_respository->homeSlides();
    }
    

    private function request_to_data_model($request){
       
            return [
                "title" => $request->title,
                "sub_title" => $request->sub_title,
                "button_text" => $request->button_text,                
                "title_ar" => $request->title_ar,
                "sub_title_ar" => $request->sub_title_ar,
                "button_text_ar" => $request->button_text_ar,
                "button_link" => $request->button_link,
            ];
      

    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "title" => $entity->title,
            "sub_title" => $entity->sub_title,
            "button_text" => $entity->button_text,            
            "title_ar" => $entity->title_ar,
            "sub_title_ar" => $entity->sub_title_ar,
            "button_text_ar" => $entity->button_text_ar,
            "button_link" => $entity->button_link,
            "image" => $entity->images->where('field','slide')->first(),

        ];
    }

}
