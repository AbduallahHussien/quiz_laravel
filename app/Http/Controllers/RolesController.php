<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Roles\Services\RolesService;
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    protected $role_service;

    public function __construct( RolesService $role_service  )
    {
        $this->role_service       = $role_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) { 

            $data = $this->role_service->all();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){

                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('1/edit', $modules_ids)):
                            $btn .=' <a href="'.route('roles.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('1/delete', $modules_ids)):
                            $btn .='<a href="'.route('roles.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;

                    })
                    ->addColumn('name', function($row){

                        
                       
                        return '<p class="text-capitalize">'.$row->name.'</p>';

                    })
                  
                    ->rawColumns(['actions','name'])
                    ->make(true);
            
        }
       
        return view('roles.roles');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = $this->role_service->get_instance();
        return view('roles.roles-form',compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = $this->role_service->create($request);
        return jsonResponse(['role'=>$role],200,__('Role created successfully'));
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
        $model = $this->role_service->find($id);
        if($model){
            $role = $this->role_service->entity_to_data_model($model);
            return view('roles.roles-form', compact('role'));
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
        $role = $this->role_service->update($id,$request);
        return jsonResponse(['role'=>$role],200,__('Role updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = $this->role_service->find($id);
        if (!$role) {
            return response()->json(['message' => __('Role already deleted!'),  'success' => false]);
        } else {
            
            
            try {
                $this->role_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }

            return response()->json(['message' => __('Role has been deleted!'),  'success' => true]);
        }

        return back();
    }
}
