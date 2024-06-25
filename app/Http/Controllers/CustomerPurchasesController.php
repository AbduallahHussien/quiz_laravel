<?php

namespace App\Http\Controllers;

use App\Domains\SalesOrders\Services\SalesOrdersService; 
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Auth;

class CustomerPurchasesController extends Controller
{
    protected $orders_service; 
    public function __construct( 
        SalesOrdersService $orders_service, 
    )

    {
        $this->orders_service       = $orders_service;
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
            $data = $this->orders_service->prepare_customer_data_table($customer_id);
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){

                        $btn ="";
                        $btn .='<a href="'.route('customer_purchases.show',$row->id).'" data-id="'.$row->id.'" class="action-btn" title="'.__('View').'" data-toggle="tooltip"><i class="fas fa-eye"></i></a>';
                        return $btn;
                    })
                    ->addColumn('vat', function($row){
                        return intval($row->vat)."%";
                    })                    
                    ->addColumn('status', function($row){
                        $status = '<span class="badge bg-warning text-dark">'.__($row->status).'</span>';
                        if($row->status == 'approved'){
                            $status = '<span class="badge bg-success">'.__($row->status).'</span>';
                        }else if($row->status == 'rejected'){
                            $status = '<span class="badge bg-danger">'.__($row->status).'</span>';
                        }
                        return $status;
                    })
                  
                    ->rawColumns(['vat','status','actions'])
                    ->make(true);
            
        } 
       
        return view('customers.purchases.purchases');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->orders_service->find($id);
        if($model){
            $order = $this->orders_service->entity_to_data_model($model);
            return view('customers.purchases.single',compact('order'));
        }else{
            die('not found');
        }
    }


}

