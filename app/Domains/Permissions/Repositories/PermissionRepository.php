<?php

namespace App\Domains\Permissions\Repositories;

use App\Domains\Permissions\Entities\Permission;
use App\Domains\Permissions\Interfaces\PermissionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PermissionRepository implements PermissionRepositoryInterface
{

    /**
    * Permission Repository constructor.
    *
    * @param Permission $model
    */
 
    public function get_roles(){
        $query = "SELECT * FROM roles ";

        return DB::select($query);
    }
    public function get_permissions(){
        $query = "SELECT * FROM permissions ";    
        return DB::select($query);
    }
    public function get_modules(){
        $query = "SELECT * FROM modules";  
        return DB::select($query);
    }
    public static function get_user_permissions($user_id){
        $query="select role_id from users where id=".$user_id;
        $role_id  = DB::select($query);
        $query = "select permissions.name as permission_name, modules.id as module_id
        ,roles_permissions.permission_id 
        from modules 
        inner join roles_permissions on modules.id  = roles_permissions.module_id
        and roles_permissions.role_id =".$role_id[0]->role_id."
        inner JOIN permissions on roles_permissions.permission_id= permissions.id";  
        return DB::select($query);
    }
    public function get_role_permissions($role_id){
        $query = "select permissions.name as permission_name, modules.id as module_id
        ,roles_permissions.permission_id 
        from modules 
        inner join roles_permissions on modules.id  = roles_permissions.module_id
        and roles_permissions.role_id =".$role_id."
        inner JOIN permissions on roles_permissions.permission_id= permissions.id";  
        return DB::select($query);
    }
    public function add_permission_role($request){
        $query = " INSERT INTO roles_permissions (role_id,module_id ,permission_id) VALUES ($request->role_id,$request->module_id,$request->permission_id);";
        return DB::insert($query); 
    } 
    // public function add_permission_module($request){
    //     $query = " INSERT INTO permissions_modules (role_id,module_id, permission_id) VALUES ($request->role_id,$request->module_id,$request->permission_id);"; 
    //     return DB::insert($query);
    //  }
     public function delete_permission_role($request){
        $query = " delete from roles_permissions where role_id =".$request->role_id." and module_id =".$request->module_id." and permission_id=".$request->permission_id.""; 
        return DB::delete($query);
        
     }
    //  public function delete_permission_module($request){
    //     $query = "delete from permissions_modules where module_id =".$request->module_id." and permission_id=".$request->permission_id." and role_id=".$request->role_id.""; 
    //     return DB::delete($query);
    // }
}