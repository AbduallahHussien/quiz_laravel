<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\User\Services\UserService;
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Rap2hpoutre\FastExcel\FastExcel;
use DB;
class UserController extends Controller
{
    protected $user_service; 
    protected $permission_service;

    public function __construct( UserService $user_service , PermissionService $permission_service )
    {
        $this->user_service       = $user_service;
        $this->permission_service = $permission_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->user_service->prepare_data_table();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){

                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('1/edit', $modules_ids)):
                            $btn .=' <a href="'.route('users.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('1/delete', $modules_ids)):
                            $btn .='<a href="'.route('users.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;

                    })
                    ->addColumn('role_name', function($row){

                        
                       
                        return '<p class="text-capitalize">'.$row->role_name.'</p>';

                    })
                    ->rawColumns(['role_name','actions'])
                    ->make(true);
            
        } 
       
        return view('users.users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->permission_service->get_roles();
        $user = $this->user_service->get_instance();
        return view('users.users-form',compact('user','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!isValidEmailFormat($request->email)){
            return response()->json(['message' => __('Invalid email address!'),  'success' => false]);
        }

        if (isEmailUnique($request->email)) {
            $user = $this->user_service->create($request);
        }else{
            return response()->json(['message' => __('This email already in use!'),  'success' => false]);
        }
        return jsonResponse(['user'=>$user],200,__('User created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->user_service->find($id);
        if($model){
            $roles = $this->permission_service->get_roles();
            $user = $this->user_service->entity_to_data_model($model);
            return view('users.users-form', compact('user','roles'));
        }
    }
    public function edit_profile($id){
        $model = $this->user_service->find($id);
        if($model){
            $user = $this->user_service->entity_to_data_model($model);
            return view('users.edit-profile', compact('user'));
        }
    }

   
  
    
    
   
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!isValidEmailFormat($request->email)){
            return response()->json(['message' => __('Invalid email address!'),  'success' => false]);
        }
        
        if (isEmailUnique($request->email,$id)) {
            $user = $this->user_service->update($id,$request);
        }else{
            return response()->json(['message' => __('This email already in use!'),  'success' => false]);
        }
        return jsonResponse(['user'=>$user],200,__('User updated successfully'));
    }


    public function get_alerts(Request $request){
        if ($request->ajax()) {
        $alerts = $this->user_service->get_alerts(auth()->user()->role_id);
        return ( $alerts );
        }
    }

    public function alerts_seen(Request $request){
        if ($request->ajax()) {
            $data = $this->user_service->alerts_seen($request->alert_id,$request->type);
             return ($data);
           
         }
    }
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user_service->find($id);
        if (!$user) {
            return response()->json(['message' => __('User already deleted!'),  'success' => false]);
        } else {
            
            
            try {
                $this->user_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }

            return response()->json(['message' => __('User has been deleted!'),  'success' => true]);
        }

        return back();
    }
}
