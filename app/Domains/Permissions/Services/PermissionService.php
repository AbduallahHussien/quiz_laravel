<?php

namespace App\Domains\Permissions\Services;

use App\Domains\Permissions\Interfaces\PermissionRepositoryInterface;
use App\Domains\Permissions\Repositories\PermissionRepository;

class PermissionService {
    private $permission_repository;

    public function __construct(
        PermissionRepositoryInterface $permission_repository,
    )
    {
        $this->permission_repository = $permission_repository;
	}

    public function get_roles(){
        return $this->permission_repository->get_roles();
    }
    public function  get_permissions(){
        return $this->permission_repository->get_permissions();
    }
    public function get_modules(){
        return $this->permission_repository->get_modules();
    }
    public static function get_user_permissions($user_id){
        return PermissionRepositoryInterface::get_user_permissions($user_id);
    }
    public  function get_role_permissions($role_id){
        return  $this->permission_repository->get_role_permissions($role_id);
    }
    public function add_permission($request){
              $add_permission_role = $this->permission_repository->add_permission_role($request);
            //   $add_permission_module = $this->permission_repository->add_permission_module($request);
        return ( $add_permission_role );
    }
    public function delete_permission($request){
            $delete_permission_role = $this->permission_repository->delete_permission_role($request);
            // $delete_permission_module = $this->permission_repository->delete_permission_module($request);
        return ( $delete_permission_role  );
    }
}