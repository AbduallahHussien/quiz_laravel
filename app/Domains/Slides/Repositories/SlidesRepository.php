<?php

namespace App\Domains\Slides\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Slides\Entities\Slides;
use App\Domains\Slides\Interfaces\SlidesRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  SlidesRepository extends BaseRepository implements SlidesRepositoryInterface
{

    /**
    * SlidesRepository constructor.
    *
    * @param Slides $model
    */
    public function __construct(Slides $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT slides.*,
        images.file as slide
        FROM   slides
            LEFT JOIN images
                ON slides.id = images.imageable_id
                AND images.field = 'slide' 
                 AND images.imageable_type like'%slides%'
                 order by slides.id ASC
                 ");
    }
    public function homeSlides(){

        return DB::select("SELECT slides.*,
        images.file as slide
        FROM   slides
            LEFT JOIN images
                ON slides.id = images.imageable_id
                AND images.field = 'slide' 
                AND images.imageable_type like'%slides%'
                WHERE slides.button_link IS NOT NULL
                 order by slides.id ASC
                 ");
    }
    

    
}
