<?php

namespace App\Domains\User\Services;
use Illuminate\Support\Str;
use App\Domains\User\Interfaces\UserRepositoryInterface;

Class UserService{

    private $user_repository;

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function prepare_data_table(){
        return $this->user_repository->prepare_data_table();
    }


    
    public function get_all_users($role){
        return $this->user_repository->get_all_users($role);
    }
  
    
    public function get_instance(){
        return $this->user_repository->get_instance();
    }

    public function all(){
        return $this->user_repository->all();
    }

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        if($request->password){
            $data_model['password'] = \Hash::make($request->password);
        }else{
            $data_model['password'] = \Hash::make(Str::random(40));
        }
        $admin = $this->user_repository->create($data_model);
        return $admin;

    }

   



    private function request_to_data_model($request){
        if($request->profile){
            $data = [
                'username' => $request->username,
            ];
        }else{
            $data = [
                'username' => $request->username,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address_ar' => $request->address_ar,
                'address_en' => $request->address_en,
                'role_id' => $request->role_id,
            ];
        }
       
        return $data;
    }

    public function find($id){
        return $this->user_repository->find($id);
    }

    public function entity_to_data_model($entity){
        return (object) [
            'id' => $entity->id,
            'username' => $entity->username,
            'name' => $entity->name,
            'phone' => $entity->phone,
            'email' => $entity->email,
            'address_ar' => $entity->address_ar,
            'address_en' => $entity->address_en,
            'password' => $entity->password,
            'role_id' => $entity->role_id,
        ];
    }

    public function update($id,$request){

        if($request->profile){
            $data_model = $this->request_to_data_model($request);
        }else{
            $data_model = $this->request_to_data_model($request);
        }
        if($request->password){
            $data_model['password'] = \Hash::make($request->password);
        }
        $user = $this->user_repository->update($id,$data_model);
        return $user;
    }
    

    public function delete($id){
        $this->user_repository->delete($id);
    }



}
