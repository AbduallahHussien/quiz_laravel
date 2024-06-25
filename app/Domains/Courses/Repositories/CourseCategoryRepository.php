<?php

namespace App\Domains\Courses\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Courses\Entities\CourseCategory;
use App\Domains\Courses\Interfaces\CourseCategoryRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  CourseCategoryRepository extends BaseRepository implements CourseCategoryRepositoryInterface
{

    /**
    * AddonsRepository constructor.
    *
    * @param CourseCategory $model
    */
    public function __construct(CourseCategory $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("select
                                course_categories.id,
                                course_categories.name ,
                                course_categories.created_at,
                                count(courses.id) as courses_count
                            from
                                course_categories
                            left join courses on
                                course_categories.id = courses.category_id
                            group by
                                course_categories.id,
                                course_categories.name,
                                course_categories.created_at");
    }
  
    
    
  


}
