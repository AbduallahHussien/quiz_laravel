<?php

namespace App\Domains\Artists\Repositories;
use App\Domains\Artists\Entities\Artists;
use App\Domains\Artists\Interfaces\ArtistsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  ArtistsRepository extends BaseRepository implements ArtistsRepositoryInterface
{

    /**
    * ArtistsRepository constructor.
    *
    * @param Artists $model
    */
    public function __construct(Artists $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT   artists.*,
                                    countries.name as country, 
                                    images.file as image
                                    FROM   artists
                                    LEFT JOIN countries
                                    ON artists.country_id = countries.id
                                    LEFT JOIN images
                                        ON artists.id = images.imageable_id
                                        AND images.field = 'artist' 
                                        AND images.imageable_type like'%artists%'
                                        order by artists.id ASC");
    }

    public function countries(){
        return DB::table('countries')->get();
    }

    public function featuredArtist($flag, $limit){
                            $query = "SELECT   
                            artists.*, 
                            images.file as image
                                FROM   artists
                            LEFT JOIN images
                                ON artists.id = images.imageable_id
                                AND images.field = 'artist' 
                                AND images.imageable_type like'%artists%'
                               
                            ";
                            if($flag){
                                $query.="
                                            WHERE artists.is_featured = 1 
                                        ";
                            }
                            $query.="
                                    order by artists.id DESC
                                    LIMIT $limit
                                    ";
                              return DB::select($query);
    }

    public function artistPainting($id){
        return DB::select(" SELECT 
        paintings.*,
        images.file as logo
        FROM   paintings
        LEFT JOIN images
        ON paintings.id = images.imageable_id
        AND images.field = 'logo' 
        AND images.imageable_type like'%paintings%'
        WHERE paintings.artist_id = $id
        AND paintings.status = 'available'
        order by paintings.id DESC
        limit 1
        ");

    }

    public function artistCategories($categoryIds){
        return DB::select("SELECT 
                            categories.*, 
                            images.file as logo
                            FROM   categories
                            LEFT JOIN images
                                    ON categories.id = images.imageable_id
                                    AND images.field = 'logo' 
                                    AND images.imageable_type like'%categories%'
                            WHERE categories.id in($categoryIds)
                            AND categories.type = 'artists'
                            order by categories.id ASC
                 ");
    }

    public function artistByCategoryId($id){
        return DB::select("SELECT   
                            artists.*, 
                            images.file as image
                                FROM   artists
                            LEFT JOIN images
                                ON artists.id = images.imageable_id
                                AND images.field = 'artist' 
                                AND images.imageable_type like'%artists%'
                            WHERE artists.category_id = $id
                                order by artists.id DESC
                               
                            ");
    }

    
    

}
