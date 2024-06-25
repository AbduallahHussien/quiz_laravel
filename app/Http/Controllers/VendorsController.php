<?php

namespace App\Http\Controllers;

use App\Domains\Vendors\Services\VendorsService; 
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class VendorsController extends Controller
{
    protected $vendors_service; 
    protected $permission_service;
    public function __construct( VendorsService $vendors_service , PermissionService $permission_service )
    {
        $this->vendors_service       = $vendors_service;
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

            $data = $this->vendors_service->prepare_data_table();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){

                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('14/edit', $modules_ids)):
                            $btn .=' <a href="'.route('vendors.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('14/delete', $modules_ids)):
                            $btn .='<a href="'.route('vendors.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;

                    })
                    ->addColumn('status', function($row){
                        $status = '';
                        if($row->status == 'pending'){
                            $status = '<span class="badge rounded-pill bg-warning text-dark">'.__('Pending').'</span>';
                        }elseif($row->status == 'approved'){
                            $status = '<span class="badge rounded-pill bg-success">'.__('Accepted').'</span>';
                        }else{
                            $status = '<span class="badge rounded-pill bg-danger">'.__('Rejected').'</span>';
                        }
                        return $status;
                    })
                  
                    ->rawColumns(['status','actions'])
                    ->make(true);
            
        } 
       
        return view('vendors.vendors');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
       // Set the default date as today's date minus 10 years
        $defaultDate = Carbon::now()->subYears(10)->format('Y-m-d');
        $countries = $this->vendors_service->countries();
        $vendor = $this->vendors_service->get_instance();
        return view('vendors.vendors-form',compact('vendor','countries','defaultDate'));
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
            $vendor = $this->vendors_service->create($request);
        }else{
            return response()->json(['message' => __('This email already in use!'),  'success' => false]);
        }
        return jsonResponse(['vendor'=>$vendor],200,__('Vendor created successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->vendors_service->find($id);
        if($model){
            $defaultDate = Carbon::now()->subYears(10)->format('Y-m-d');
            $countries = $this->vendors_service->countries();
            $vendor = $this->vendors_service->entity_to_data_model($model);
            return view('vendors.vendors-form', compact('vendor','countries','defaultDate'));
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
         // check if profile
         if(isset($request->old_password)){
                $data = $this->vendors_service->find($id);
                if(\Hash::check($request->old_password ,$data->password)){
                    $request->except('old_password');
                }else{
                    return response()->json(['message' => __('Old password is invalid!'),  'success' => false]);
                }
            
         } 
         //end
        if(!isValidEmailFormat($request->email)){
            return response()->json(['message' => __('Invalid email address!'),  'success' => false]);
        }

        if (isEmailUnique($request->email,$id)) {
            $vendor = $this->vendors_service->update($id,$request);
        }else{
            return response()->json(['message' => __('This email already in use!'),  'success' => false]);
        }
        return jsonResponse(['vendor'=>$vendor],200,__('Vendor updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = $this->vendors_service->find($id);
        if (!$vendor) {
            return response()->json(['message' => __('Vendor already deleted!'),  'success' => false]);
        } else {
             
            
            try {
                $this->vendors_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }

            return response()->json(['message' => __('Vendor has been deleted!'),  'success' => true]);
        }

        return back();
    }
    public function profile()
    {
        $vendor = Auth::guard('vendor')->user();
        return view('vendors.profile',compact('vendor'));
    }
    public function edit_profile(){
        $id = Auth::guard('vendor')->id();
        $model = $this->vendors_service->find($id);
        if($model){
            $defaultDate = Carbon::now()->subYears(10)->format('Y-m-d');
            $countries = $this->vendors_service->countries();
            $vendor = $this->vendors_service->entity_to_data_model($model);
            return view('vendors.edit-profile', compact('vendor','countries','defaultDate'));
        }
       
    }
}
