<?php
use App\Domains\Permissions\Repositories\PermissionRepository;
use App\Domains\Categories\Repositories\CategoriesRepository;
use App\Domains\Paintings\Repositories\PaintingsRepository;
use App\Domains\Categories\Services\CategoriesService;

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




// complaint_status_enum('PENDING');

 function get_user_permission(){
    if( auth()->user()){
        $userID = auth()->user()->id;
        $data = PermissionRepository::get_user_permissions( $userID);
        
         $modules_ids = array();
         $permission_names = array();
         foreach($data as $permission){
            $modules_ids['modules_ids'][]=$permission->module_id.'/'.$permission->permission_name;
            $permission_names['permission_names'][]=$permission->permission_name;  
         }
         
         return array($modules_ids,);
        }
    }


function settings(){
    $settings = \DB::select('SELECT name , value from settings  order by id ASC');
    $data = array();
    foreach( $settings as $row):
        $data[$row->name]= $row->value;
    endforeach;
    return $data;
}

function isEmailUnique($email, $userId = null)
{
    $isUnique = true;

    // Check if email exists in the `users` table (excluding the current user if provided)
    $query = DB::table('users')->where('email', $email);
    if ($userId !== null) {
        $query->where('id', '<>', $userId);
    }
    if ($query->exists()) {
        $isUnique = false;
    }

    $query = DB::table('customers')->where('email', $email);
    if ($userId !== null) {
        $query->where('id', '<>', $userId);
    }
    if ($query->exists()) {
        $isUnique = false;
    }


    $query = DB::table('vendors')->where('email', $email);
    if ($userId !== null) {
        $query->where('id', '<>', $userId);
    }
    if ($query->exists()) {
        $isUnique = false;
    }

    return $isUnique;
}


function isValidEmailFormat($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
} 
function SidebarCategories(){
  
    return CategoriesRepository::SidebarCategories();

}
function NavCategories($limit){
        $data = [];
    
        // Retrieve parent categories
        $parents = CategoriesRepository::getParentCat($limit);
    
        // Loop through parent categories
        foreach ($parents as $parent) {
            $parentCat = [
                'id' => $parent->id,
                'name' => $parent->name,
                'slug' => $parent->slug,
            ];
    
            // Retrieve subcategories for the current parent category
            $subcats = CategoriesRepository::getSubCat($parent->id);
    
            $subs = [];
    
            // Check if there are subcategories
            if ($subcats) {
                // Loop through subcategories
                foreach ($subcats as $sub) {
                    $subs[] = [
                        'id' => $sub->id,
                        'name' => $sub->name,
                        'slug' => $sub->slug,
                    ];
                }
            }
    
            // Assign subcategories to the parent category
            $parentCat['subs'] = $subs;
    
            // Add the parent category to the data array
            $data[] = $parentCat;
        }
    
        return $data;

}
function getCartCount($customer_id){
    $query = \DB::select('SELECT COUNT(painting_id) as count FROM cart WHERE customer_id = '.$customer_id.' ');
    $data = array(
        "count" =>  $query[0]->count,
    );
    
    return  $data;
}

function getCart(){
    return PaintingsRepository::cart();
}

function canAddToCart(){
   if(!Auth::check() || Auth::check() && Auth::guard('customer')->check()){
        return true;
   }else{
        return false;
   }
}
function canAddToWishlist(){
    if(!Auth::check() || Auth::check() && Auth::guard('customer')->check()){
         return true;
    }else{
         return false;
    }
 }
 function defaultCurrency(){
    return "SAR";
 }
 function getVat(){
    return 15;
 }


 function decodeAndDisplayAsCommaList($encodedString) {
    $decodedData = [];
    parse_str($encodedString, $decodedData);

    $formattedValues = [];
    foreach ($decodedData as $key => $value) {
        $formattedValues[] = "$key: " . urldecode($value);
    }

    return implode(", ", $formattedValues);
}
 