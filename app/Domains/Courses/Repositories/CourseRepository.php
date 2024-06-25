<?php

namespace App\Domains\Courses\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Courses\Entities\Course;
use App\Domains\Courses\Interfaces\CourseRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  CourseRepository extends BaseRepository implements CourseRepositoryInterface
{

    /**
    * CourseRepository constructor.
    *
    * @param Course $model
    */
    public function __construct(Course $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table($id){

        return DB::select("SELECT courses.*, course_categories.name as category  from courses
                                LEFT JOIN course_categories
                                    ON courses.category_id = course_categories.id
                                        LEFT JOIN images
                                            ON courses.id = images.imageable_id
                                            AND images.field = 'logo' 
                                            AND images.imageable_type like'%Courses%'
                                            where  courses.category_id = $id
                                            order by courses.id ASC

        ");
        
    }

    public function findCoursesByName($term){
        return DB::select("select
                                id,
                                title
                            from
                                courses
                            where
                                title like '%$term%'");
    }
    
    
  


}
