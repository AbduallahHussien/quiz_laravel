<?php

namespace App\Http\Controllers;

use App\Domains\Customers\Services\CustomersService; 
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class CustomersController extends Controller
{
    protected $customers_service; 
    protected $permission_service;
    public function __construct( CustomersService $customers_service , PermissionService $permission_service )
    {
        $this->customers_service       = $customers_service;
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

            $data = $this->customers_service->prepare_data_table();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){

                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('4/edit', $modules_ids)):
                            $btn .=' <a href="'.route('customers.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('4/delete', $modules_ids)):
                            $btn .='<a href="'.route('customers.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;

                    })
                  
                    ->rawColumns(['actions'])
                    ->make(true);
            
        } 
       
        return view('customers.customers');
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
        $countries = $this->customers_service->countries();
        $customer = $this->customers_service->get_instance();
        return view('customers.customers-form',compact('customer','countries','defaultDate'));
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
            $customer = $this->customers_service->create($request);
        }else{
            return response()->json(['message' => __('This email already in use!'),  'success' => false]);
        }
        return jsonResponse(['customer'=>$customer],200,__('Customer created successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->customers_service->find($id);
        if($model){
            $defaultDate = Carbon::now()->subYears(10)->format('Y-m-d');
            $countries = $this->customers_service->countries();
            $customer = $this->customers_service->entity_to_data_model($model);
            return view('customers.customers-form', compact('customer','countries','defaultDate'));
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
            $data = $this->customers_service->find($id);
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
            $customer = $this->customers_service->update($id,$request);
        }else{
            return response()->json(['message' => __('This email already in use!'),  'success' => false]);
        }
        return jsonResponse(['customer'=>$customer],200,__('Customer updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = $this->customers_service->find($id);
        if (!$customer) {
            return response()->json(['message' => __('Customer already deleted!'),  'success' => false]);
        } else {
             
            
            try {
                $this->customers_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }

            return response()->json(['message' => __('Customer has been deleted!'),  'success' => true]);
        }

        return back();
    }


    /**
     * find custoers by barcode or name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findCustomers(Request $request)
    {
 
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $customers = $this->customers_service->findCustomerByNameOrPhone($term);

        $formatted_customers = [];

        foreach ($customers as $customer) {
            $formatted_customers[] = ['id' => $customer->id, 'text' => $customer->full_name];
        }

        return \Response::json($formatted_customers);
    }

    public function profile()
    {
        return view('customers.profile');
    }

    public function edit_profile()
    {
        $id = Auth::guard('customer')->id();
        $model = $this->customers_service->find($id);
        if($model){
            $defaultDate = Carbon::now()->subYears(10)->format('Y-m-d');
            $countries = $this->customers_service->countries();
            $customer = $this->customers_service->entity_to_data_model($model);
            return view('customers.edit-profile', compact('customer','countries','defaultDate'));
        }
    }
}
