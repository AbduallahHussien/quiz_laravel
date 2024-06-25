<?php

namespace App\Http\Controllers;

use App\Domains\SalesOrders\Services\SalesOrdersService; 
use App\Domains\Customers\Services\CustomersService;
use App\Domains\Locations\Services\LocationsService;
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ReturnsController extends Controller
{
    protected $orders_service; 
    protected $permission_service;
    protected $customers_service;
    public function __construct( 
        SalesOrdersService $orders_service, 
        PermissionService $permission_service,
        CustomersService $customers_service,
    )

    {
        $this->orders_service       = $orders_service;
        $this->permission_service   = $permission_service;
        $this->customers_service    = $customers_service;
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
            $order_type = $order->order_type;
            if($order_type == 'host_exhibition'){
                return $this->displayHostExhibitionForm($order);
            }else if($order_type == 'renting_halls'){
                return $this->displayRentingHallsForm($order);
            }else{
                return $this->displayPaintingsForm($order);
            }

        }
    }


    private function displayPaintingsForm($order){

        return view('returns.paintings',compact('order'));
    }

    private function displayHostExhibitionForm($order){
        return view('returns.host_exhibition',compact('order'));
    }

    private function displayRentingHallsForm($order){
        return view('returns.renting_halls',compact('order'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = $this->orders_service->handle_returns($request);
        return jsonResponse(['order'=>$order],200,__('Returns updated successfully'));
    }


}
