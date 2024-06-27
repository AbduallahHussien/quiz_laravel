<?php
use App\Domains\Curd\Repositories\CurdRepository;
use App\Domains\User\Repositories\UserRepository;


if (!function_exists('json_response')) {

function jsonResponse($data = [], $code = 200, $message = "")
{
    return response()->json([
        'data'  => $data,
        'code'  => $code,
        'message' => $message,
    ], $code);
}
}

if (!function_exists('get_course_by_id')) {
    function get_course_by_id($id){
    
        return CurdRepository::get_course_by_id($id);

    }
}
if (!function_exists('setting')) {
    function setting() {
        return DB::table('setting')
                ->select('*')
                ->where('setting_id', 1)
                ->first(); 
    }
}
if (!function_exists('get_settings')) {
    function get_settings($key = '') {
        $setting = DB::table('settings')
                    ->where('key', $key)
                    ->value('value');

        return $setting;
    }
}
if (!function_exists('get_user_image_url')) {
    function  get_user_image_url($user_id) {
        return CurdRepository::get_course_by_id($user_id);
    }
}
if (!function_exists('get_admin_details')) {
    function  get_admin_details() {
        return UserRepository::get_admin_details();
    }
}




 