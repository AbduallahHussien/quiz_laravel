<?php

namespace App\Http\Controllers;

use App\Domains\Customers\Services\AddressesService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Auth;

class AddressesController extends Controller
{
    protected $addresses_service; 

    public function __construct(
        AddressesService $addresses_service
    )
    {
        $this->addresses_service   = $addresses_service;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {           
        if ($request->ajax()) {
            $customer_id = Auth::guard('customer')->id();
            $data = $this->addresses_service->prepare_data_table($customer_id);
        
                return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('type', function($row){
                        $type = '<span class="badge bg-info">'.__('shipping').'</span>';
                        if($row->is_default){
                            $type = '<span class="badge bg-success">'.__('billing').'</span>';
                        }
                        return $type;
                    })

                    
                    ->addColumn('actions', function($row){

                        $btn ="";
                        $btn .=' <a href="'.route('customer_addresses.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';

                        if($row->shipping_address == '' && !$row->is_default){
                            $btn .='<a href="'.route('customer_addresses.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        }
                        return $btn;

                    })
                
                    ->rawColumns(['type', 'actions'])
                    ->make(true);
        } 

        return view('customers.addresses.addresses');
   }
    
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $address = $this->addresses_service->get_instance();
        $countries = $this->addresses_service->countries();
        return view('customers.addresses.address-form',compact('address','countries'));
    }


    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $customer_id = Auth::guard('customer')->id();
       $address = $this->addresses_service->create($request, $customer_id);
       return jsonResponse(['address'=>$address],200,__('Address created successfully'));
   }


   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $model = $this->addresses_service->find($id);
        if($model){
            $address = $this->addresses_service->entity_to_data_model($model);
            $countries = $this->addresses_service->countries();
            return view('customers.addresses.address-form', compact('address','countries'));
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
       $address = $this->addresses_service->update($id,$request);
       return jsonResponse(['address'=>$address],200,__('Address updated successfully'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $address = $this->addresses_service->find($id);
       if (!$address) {
           return response()->json(['message' => __('Address already deleted!'),  'success' => false]);
       } else {
            
           
           try {
               $this->addresses_service->delete($id);
           } catch (\Throwable $th) {
               return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
           }

           return response()->json(['message' => __('Address has been deleted!'),  'success' => true]);
       }

       return back();
   }

}
