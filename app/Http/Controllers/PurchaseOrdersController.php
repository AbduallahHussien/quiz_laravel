<?php

namespace App\Http\Controllers;

use App\Domains\PurchaseOrders\Services\PurchaseOrdersService; 
use App\Domains\Suppliers\Services\SuppliersService; 
use App\Domains\Locations\Services\LocationsService;
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;


class PurchaseOrdersController extends Controller
{
    protected $orders_service; 
    protected $permission_service;
    protected $suppliers_service;
    protected $locations_service; 
    public function __construct( 
        PurchaseOrdersService $orders_service, 
        PermissionService $permission_service,
        SuppliersService $suppliers_service,
        LocationsService $locations_service,
    )

    {
        $this->orders_service       = $orders_service;
        $this->permission_service = $permission_service;
        $this->suppliers_service = $suppliers_service;
        $this->locations_service       = $locations_service;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->orders_service->prepare_data_table();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){

                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('15/edit', $modules_ids)):
                            $btn .=' <a href="'.route('purchase-orders.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('15/delete', $modules_ids)):
                            $btn .='<a href="'.route('purchase-orders.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;

                    })
                  
                    ->rawColumns(['actions'])
                    ->make(true);
            
        } 
       
        return view('purchase_orders.orders');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
        $order = $this->orders_service->get_instance();
        $suppliers = $this->suppliers_service->all();
        $locations = $this->locations_service->all();
        return view('purchase_orders.order',compact('order','suppliers','locations'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = $this->orders_service->create($request);
        return jsonResponse(['order'=>$order],200,__('Order created successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->orders_service->find($id);
        if($model){
            $suppliers = $this->suppliers_service->all();
            $locations = $this->locations_service->all();
            $order = $this->orders_service->entity_to_data_model($model);
            return view('purchase_orders.order',compact('order','suppliers','locations'));
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
        $model = $this->orders_service->find($id);
        $order = $this->orders_service->update($id,$request);
        return jsonResponse(['order'=>$order],200,'Order updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = $this->orders_service->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order already deleted!', 'success' => false]);
        } else {
            $this->orders_service->remove_items($order);
            $this->orders_service->delete($id);
            return response()->json(['message' => 'Order has been deleted!', 'success' => true]);
        }

        return back();
    }

}
