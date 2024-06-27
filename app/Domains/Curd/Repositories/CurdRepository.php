<?php

namespace App\Domains\Curd\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Curd\Entities\Curd;
use App\Domains\Curd\Interfaces\CurdRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  CurdRepository extends BaseRepository implements CurdRepositoryInterface
{

    /**
    * CurdRepository constructor.
    *
    * @param Curd $model
    */
    public function __construct(Curd $model)
    {
        parent::__construct($model);
    }

    public static function get_course_by_id($course_id = "") {
        return DB::table('subject')
                 ->where('id', $course_id)
                 ->first(); // Use first() to get a single result
    }
  
    
    
  


}
