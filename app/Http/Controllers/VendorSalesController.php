<?php

namespace App\Http\Controllers;

use App\Domains\SalesOrders\Services\SalesOrdersService; 
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Auth;

class VendorSalesController extends Controller
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
            $vendor_id = Auth::guard('vendor')->id();
            $data = $this->orders_service->prepare_vendor_data_table($vendor_id);
          
                return Datatables::of($data)
                    ->addIndexColumn()
                                      
                    ->addColumn('status', function($row){
                        $status = '<span class="badge bg-warning text-dark">'.__($row->status).'</span>';
                        if($row->is_returned){
                            $status = '<span class="badge bg-danger">'.__('returned').'</span>';
                        }else if($row->status == 'approved'){
                            $status = '<span class="badge bg-success">'.__('completed').'</span>';
                        }else if($row->status == 'rejected'){
                            $status = '<span class="badge bg-danger">'.__($row->status).'</span>';
                        }
                        return $status;
                    })
                  
                    ->rawColumns(['status'])
                    ->make(true);
            
        } 
       
        return view('vendors.sales.sales');
    }
}

