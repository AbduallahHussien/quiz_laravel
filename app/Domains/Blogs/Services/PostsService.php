<?php

namespace App\Domains\Blogs\Services;


use App\Domains\Blogs\Interfaces\PostsRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use App\Helpers\SlugHelper;


Class PostsService{

    private $posts_respository;
    private $image_repository;

    public function __construct(PostsRepositoryInterface $posts_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->posts_respository = $posts_respository;
        $this->image_repository = $image_repository;
       
	}

   
    public function update($id,$request){

        $data_model = $this->request_to_data_model($request);
        $slug = SlugHelper::generateUniqueSlug($id,$request->slug,'posts','slug');
        $data_model['slug'] = $slug;
        $post = $this->posts_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($post , "post","post",$request->image);
        }
        return $post;
    }

    public function get_instance(){
        return $this->posts_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->posts_respository->prepare_data_table();
    }
    public function featuredPosts($limit){
        return $this->posts_respository->featuredPosts($limit);
    }
    

    public function all(){
        return $this->posts_respository->all();
    }

    public function find($id){
        return $this->posts_respository->find($id);
    }

    public function delete($id){
        return $this->posts_respository->delete($id);
    }
    public function PostsWithPaginate($perPage){
       return $this->posts_respository->PostsWithPaginate($perPage);
    }

    public function findPostBySlug($slug){
        return $this->posts_respository->findPostBySlug($slug);
     }
    
    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $slug = SlugHelper::generateUniqueSlug('',$request->slug,'posts','slug');
        $data_model['slug'] = $slug;
        $post = $this->posts_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $post, "post","post");
        }
        return $post;

    }

    private function request_to_data_model($request){
       
        return 
        [
            'title'=> $request->title,
            'slug'=> $request->slug,
            'content'=> $request->content,
            'category_id'=> $request->category_id,
            'language'=> $request->language,
        ];
    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            'title'=> $entity->title,
            'slug'=> $entity->slug,
            'content'=> $entity->content,
            'category_id'=> $entity->category_id,
            'language'=> $entity->language,
            "image" => $entity->images->where('field','post')->first(),
        ];
    }
   
}
