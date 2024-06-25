<?php

namespace App\Http\Controllers;

use App\Domains\Suppliers\Services\SuppliersService; 
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class SuppliersController extends Controller
{
    protected $suppliers_service; 
    protected $permission_service;
    public function __construct( SuppliersService $suppliers_service , PermissionService $permission_service )
    {
        $this->suppliers_service       = $suppliers_service;
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

            $data = $this->suppliers_service->prepare_data_table();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){

                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('25/edit', $modules_ids)):
                            $btn .=' <a href="'.route('suppliers.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('25/delete', $modules_ids)):
                            $btn .='<a href="'.route('suppliers.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;

                    })
                  
                    ->rawColumns(['actions'])
                    ->make(true);
            
        } 
       
        return view('suppliers.suppliers');
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
        $countries = $this->suppliers_service->countries();
        $supplier = $this->suppliers_service->get_instance();
        return view('suppliers.suppliers-form',compact('supplier','countries','defaultDate'));
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
            $supplier = $this->suppliers_service->create($request);
        }else{
            return response()->json(['message' => __('This email already in use!'),  'success' => false]);
        }
        return jsonResponse(['supplier'=>$supplier],200,__('Supplier created successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->suppliers_service->find($id);
        if($model){
            $defaultDate = Carbon::now()->subYears(10)->format('Y-m-d');
            $countries = $this->suppliers_service->countries();
            $supplier = $this->suppliers_service->entity_to_data_model($model);
            return view('suppliers.suppliers-form', compact('supplier','countries','defaultDate'));
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

         //end
        if(!isValidEmailFormat($request->email)){
            return response()->json(['message' => __('Invalid email address!'),  'success' => false]);
        }

        if (isEmailUnique($request->email,$id)) {
            $supplier = $this->suppliers_service->update($id,$request);
        }else{
            return response()->json(['message' => __('This email already in use!'),  'success' => false]);
        }
        return jsonResponse(['supplier'=>$supplier],200,__('Supplier updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = $this->suppliers_service->find($id);
        if (!$supplier) {
            return response()->json(['message' => __('Supplier already deleted!'),  'success' => false]);
        } else {
             
            
            try {
                $this->suppliers_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }

            return response()->json(['message' => __('Supplier has been deleted!'),  'success' => true]);
        }

        return back();
    }

}
