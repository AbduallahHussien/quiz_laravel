<?php

namespace App\Http\Controllers;
use App\Domains\SalesOrders\Services\SalesOrdersService; 
use App\Domains\Customers\Services\CustomersService;
use App\Domains\Locations\Services\LocationsService;
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;


class SalesOrdersController extends Controller
{
    protected $orders_service; 
    protected $permission_service;
    protected $customers_service;
    protected $locations_service; 
    public function __construct( 
        SalesOrdersService $orders_service, 
        PermissionService $permission_service,
        CustomersService $customers_service,
        LocationsService $locations_service,
    )

    {
        $this->orders_service       = $orders_service;
        $this->permission_service   = $permission_service;
        $this->customers_service    = $customers_service;
        $this->locations_service    = $locations_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter = [
                'from'      => $request->from,
                'to'        => $request->to,
                'status' =>$request->status,
                'phone' =>$request->phone
            ];

            $data = $this->orders_service->prepare_data_table($filter);
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){

                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $encodedOrderId = Crypt::encrypt($row->id);


                        $btn ='<a href="'.route('invoice.show',$encodedOrderId).'" class="action-btn print-icon" title="'.__('Print Invoice').'" data-toggle="tooltip"><i class="fas fa-print"></i></a>';
                        if(in_array('16/edit', $modules_ids)):
                            $btn .=' <a href="'.route('sales-orders.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('16/delete', $modules_ids)):
                            if($row->status == 'pending'){
                                $btn .='<a href="'.route('sales-orders.approve',$row->id).'" data-id="'.$row->id.'" class="approve approve-icon" title="'.__('Approve').'" data-toggle="tooltip"><i class="material-icons">done</i></a>';
                                $btn .='<a href="'.route('sales-orders.reject',$row->id).'" data-id="'.$row->id.'" class="reject reject-icon" title="'.__('Reject').'" data-toggle="tooltip"><i class="material-icons">close</i></a>';
                            }else if($row->status == 'rejected'){
                                $btn .='<a href="'.route('sales-orders.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                            }
                        endif;
                        if(in_array('19/view', $modules_ids)):
                            $class = "returns-cell";
                            if($row->return_id){
                                $class .=" has-returns"; 
                            }
                            $btn .='<a href="'.route('returns.show',$row->id).'" data-id="'.$row->id.'"  title="'.__('Returns').'" data-toggle="tooltip" class="'.$class.'"><i class="material-icons">keyboard_return</i></a>';
                        endif;
                            return $btn;

                    })
                    ->addColumn('vat', function($row){
                        return intval($row->vat)."%";
                    })                    
                    ->addColumn('type', function($row){
                        return '<span class="badge bg-secondary">'.$row->order_type.'</span>';
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
                  
                    ->rawColumns(['vat','type','status','actions'])
                    ->make(true);
            
        } 
       
        return view('sales_orders.orders');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $order = $this->orders_service->get_instance();
        $locations = $this->locations_service->all();
        $customers = [];
        if ($request->has('order-type')) {
            $order_type = $request->input('order-type');
            if($order_type == 'host_exhibition'){
                return $this->displayHostExhibitionForm($order, $customers, $locations);
            }else if($order_type == 'renting_halls'){
                return $this->displayRentingHallsForm($order, $customers, $locations);
            }else{
                return $this->displayPaintingsForm($order, $customers, $locations);
            } 
        }else{
            return $this->displayPaintingsForm($order, $customers, $locations);
        }
    }

    private function displayPaintingsForm($order, $customers, $locations){

        return view('sales_orders.order',compact('order', 'customers', 'locations'));
    }

    private function displayHostExhibitionForm($order, $customers, $locations){
        return view('sales_orders.host_exhibition',compact('order', 'customers', 'locations'));
    }

    private function displayRentingHallsForm($order, $customers, $locations){
        return view('sales_orders.renting_halls',compact('order', 'customers', 'locations'));
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
        $locations = $this->locations_service->all();
        if($model){
            $order = $this->orders_service->entity_to_data_model($model);
            $customers = [$this->customers_service->find($order->customer_id)];
            $order_type = $order->order_type;
            if($order_type == 'host_exhibition'){
                return $this->displayHostExhibitionForm($order, $customers, $locations);
            }else if($order_type == 'renting_halls'){
                return $this->displayRentingHallsForm($order, $customers, $locations);
            }else{
                return $this->displayPaintingsForm($order, $customers, $locations);
            }

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
            $this->orders_service->remove_paintings($order);
            $this->orders_service->remove_rooms($order);
            $this->orders_service->remove_items($order);
            $this->orders_service->delete($id);
            return response()->json(['message' => 'Order has been deleted!', 'success' => true]);
        }

        return back();
    }


    /**
     * Approve sales order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $order = $this->orders_service->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found!', 'success' => false]);
        } else {
            $this->orders_service->approve($order);
            return response()->json(['message' => 'Order has been approved!', 'success' => true]);
        }

        return back();
    }

    /**
     * Reject sales order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject($id)
    {
        $order = $this->orders_service->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found!', 'success' => false]);
        } else {
            $this->orders_service->reject($order);
            return response()->json(['message' => 'Order has been rejected!', 'success' => true]);
        }

        return back();
    }




}
