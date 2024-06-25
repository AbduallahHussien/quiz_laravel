<?php

namespace App\Domains\Artists\Services;

use App\Domains\Artists\Interfaces\ArtistsRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;

Class ArtistsService{

    private $artists_respository;
    private $image_repository;

    public function __construct(ArtistsRepositoryInterface $artists_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->artists_respository = $artists_respository;
        $this->image_repository = $image_repository;
       
	}

   
    public function update($id,$request){

        $data_model = $this->request_to_data_model($request);
        $artist = $this->artists_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($artist , "artist","artist",$request->image);
        }
        return $artist;
    }

    /**
     * Get Paintings.
     *
     * @param  string  $flag
     * @param  int  $num
     * @return \Illuminate\Http\Response
     */
    public function featuredArtist($flag, $limit)
    {
        $data = [];
        $arists = $this->artists_respository->featuredArtist($flag, $limit);
        foreach( $arists as  $arist){
            //GET ARTIST PAINTINGS
                $painting= $this->artists_respository->artistPainting($arist->id);
            //END
            //Append DATA
            $data[] = 
                    array(
                        'artist'=>(object) $arist,
                        'painting'=>($painting)?(object)$painting[0]:null,
                        ); 
        }
        return  $data;
    }

    public function artistCategories(){
        $data = [];
        $categoryIds = env('ARTIST_CATEGORIES');
        $categories = $this->artists_respository->artistCategories($categoryIds);

        foreach( $categories as  $category){
            //GET ARTISTs 
                $artists = $this->artists_respository->artistByCategoryId($category->id);
            //END
            //Append DATA
            $data[] = 
                    array(
                        'category'=>(object) $category,
                        'artists'=>($artists)?(object)$artists:null,
                        ); 
        }
        return  $data;
    }
    

    

    public function get_instance(){
        return $this->artists_respository->get_instance();
    }
    public function countries(){
        return $this->artists_respository->countries();
    }

    public function prepare_data_table(){
        return $this->artists_respository->prepare_data_table();
    }

    public function all(){
        return $this->artists_respository->all();
    }

    public function find($id){
        return $this->artists_respository->find($id);
    }

    public function delete($id){
        $this->artists_respository->delete($id);
    }
    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $artist = $this->artists_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $artist, "artist","artist");
        }
        return $artist;

    }

    private function request_to_data_model($request){
       
        return 
        [
            'full_name'=> $request->full_name,
            'full_name_ar'=> $request->full_name_ar,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'gender'=> $request->gender,
            'birth_date'=> $request->birth_date,
            'country_id'=> $request->country_id,
            'bio'=> $request->bio,
            'category_id'=> $request->category_id,
            'is_featured' => $request->has('is_featured') ? true : false,

        ];
    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            'full_name'=> $entity->full_name,
            'full_name_ar'=> $entity->full_name_ar,
            'email'=> $entity->email,
            'phone'=> $entity->phone,
            'gender'=> $entity->gender,
            'birth_date'=> $entity->birth_date,
            'country_id'=> $entity->country_id,
            'is_featured'=> $entity->is_featured,
            'bio'=> $entity->bio,
            'category_id'=> $entity->category_id,
            "image" => $entity->images->where('field','artist')->first(),
        ];
    }
   
}
