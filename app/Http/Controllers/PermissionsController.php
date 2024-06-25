<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Domains\Permissions\Services\PermissionService;

class PermissionsController extends Controller 
{
    protected $permission_service;
    public function __construct( PermissionService $permission_service)
    {
        $this->permission_service = $permission_service;
    }
    public function index()
    {
        $filter = '';
        $roles = $this->permission_service->get_roles();
        $permissions = $this->permission_service->get_permissions();
        $modules = $this->permission_service->get_modules();

        return view('permissions.permission',compact('roles','permissions','modules'));
    }
    public function get_role_permissions(Request $request){
        if ($request->ajax()) {
            $data = $this->permission_service->get_role_permissions($request->role_id);
             return ($data );
           
         }
    }
    public function store(Request $request){

         if ($request->ajax() &&  $request->method == 'add') {
                $data = $this->permission_service->add_permission($request);
                return ($data);
         }elseif($request->ajax() &&  $request->method =='delete'){
                $data = $this->permission_service->delete_permission($request);
                return ($data);
         }
    }


}
