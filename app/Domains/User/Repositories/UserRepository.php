<?php

namespace App\Domains\User\Repositories;

use App\Models\User;
use App\Domains\User\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * CompanyRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public static function get_user_image_url($user_id)
    {
        $user = DB::table('students')->where('id', $user_id)->first();
        $imagePath = public_path('resources/images/users/' . $user->profile_image);
        if ( $user && file_exists( $imagePath )){
            return $imagePath;

        }else{
            return public_path('resources/images/users/placeholder.png');

        }
    
    }
    public static function get_admin_details()
    {
        $admin = DB::table('admin')->where('operator_id', 1)->first();

        return $admin;
    }
    
    
    
    


   

   

}
