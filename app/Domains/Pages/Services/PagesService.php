<?php

namespace App\Domains\Pages\Services;

use App\Domains\Pages\Interfaces\PagesRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Helpers\SlugHelper;

Class PagesService{

    private $pages_respository;

    public function __construct(PagesRepositoryInterface $pages_respository)
	{
        $this->pages_respository = $pages_respository;
       
	}


    public function create($request){
        $data_model = $this->request_to_data_model($request);
        $slug = SlugHelper::generateUniqueSlug('',$request->slug,'pages','slug');
        $data_model['slug'] = $slug;
        $pages = $this->pages_respository->create($data_model);
        return $pages;
    }
    
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $slug = SlugHelper::generateUniqueSlug($id,$request->slug,'pages','slug');
        $data_model['slug'] = $slug;
        $pages = $this->pages_respository->update($id,$data_model);
        return $pages;
    }

    public function get_instance(){
        return $this->pages_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->pages_respository->prepare_data_table();
    }

    public function all(){
        return $this->pages_respository->all();
    }

    public function find($id){
        return $this->pages_respository->find($id);
    }

    public function delete($id){
        $this->pages_respository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                "title" => $request->title,
                "slug" => $request->slug,
                "content" => $request->content,
                "language" => $request->language,
            ];
    }

    public function entity_to_data_model($entity){
        return (object) [
            "id"        => $entity->id,
            "title"     => $entity->title,
            "slug"      => $entity->slug,
            "content"   => $entity->content,
            "language"   => $entity->language,
        ];
    }

    public function findPageBySlug($slug){
        return $this->pages_respository->findPageBySlug($slug);
     }
    
   
}
