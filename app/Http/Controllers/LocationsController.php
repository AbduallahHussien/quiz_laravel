<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Locations\Services\LocationsService;
use App\Domains\Customers\Services\CustomersService;
use App\Domains\Addons\Services\ItemsService; 
use Yajra\DataTables\Facades\DataTables;
class LocationsController extends Controller
{
    protected $locations_service; 
    protected $customers_service;  
    protected $items_service;  
    protected $permission_service;
    public function __construct( 
        LocationsService $locations_service,
        ItemsService $items_service,
        CustomersService $customers_service 
    )
    {
        $this->locations_service       = $locations_service;
        $this->items_service           = $items_service;
        $this->customers_service       = $customers_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
 
            $data = $this->locations_service->prepare_data_table();
            $permissions      =  get_user_permission();
            $modules_ids      = $permissions[0]['modules_ids'];
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('items', function($row) use ($modules_ids){
                        $btn ="";
                        if(in_array('9/edit', $modules_ids)):
                            $btn .=' <a href="'.route('locations.stock',$row->id).'"  title="'.__('Stock').'" data-toggle="tooltip"><i class="material-icons">inventory_2</i>';
                        endif;
                        return $btn;
                    })
                    ->addColumn('actions', function($row) use ($modules_ids){
 
                        
                        
                        $btn ="";
                        if(in_array('9/edit', $modules_ids)):
                            $btn .=' <a href="'.route('locations.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('9/delete', $modules_ids)):
                            $btn .='<a href="'.route('locations.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;
 
                    })
                  
                    ->rawColumns(['items','actions'])
                    ->make(true);
            
        } 
       
        return view('locations.locations');
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->locations_service->countries();
        $cities = $this->locations_service->cities();
        $location = $this->locations_service->get_instance();
        return view('locations.locations-form',compact('location','countries','cities'));
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = $this->locations_service->create($request);
        return jsonResponse(['location'=>$location],200,__('Location created successfully'));
    }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function stock(Request $request, $id)
    {
        $location = $this->locations_service->find($id);
        if ($request->ajax()) {
            $data = $this->locations_service->prepare_stock_data_table($id);
                return Datatables::of($data)
                ->addColumn('actions', function($row) use($id){

                    $permissions      =  get_user_permission();
                    $modules_ids      = $permissions[0]['modules_ids'];
                    
                    $btn ="";
                    if(in_array('9/view', $modules_ids) && $row->quantity):
                        $btn .='<a href="'.route('locations.transfer',[$id, $row->item_id]).'"  class="action-btn transfer" title="'.__('Transfer').'" data-toggle="tooltip"><i class="fas fa-share"></i></a>';
                    endif;
                    return $btn;

                })
              
                ->rawColumns(['actions'])
                ->make(true);
        } 
       
        return view('locations.stock',compact('location'));
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->locations_service->find($id);
        if($model){
            $countries = $this->locations_service->countries();
            $cities = $this->locations_service->cities();
            $location = $this->locations_service->entity_to_data_model($model);
            return view('locations.locations-form', compact('location','countries','cities'));
        }
    }

    /**
     * Show the form for transfers between stocks.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transfer($location_id,$item_id)
    {
        $transfer_item = $this->items_service->getTransferItem($item_id, $location_id);
        if($transfer_item){
            $location = $this->locations_service->find($location_id);
            $locations = $this->locations_service->allWithout([$location_id]);
            return view('locations.transfer', compact('location','locations','transfer_item'));
        }
    }


    /**
    * Transfer quantity to a location.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function transferToLocation(Request $request, $from_location, $item_id)
    {
        $this->locations_service->quantity_to_store($from_location, $item_id, -$request->quantity);
        $this->locations_service->quantity_to_store($request->location_id, $item_id, $request->quantity);
        return jsonResponse(['item_id'=>$item_id],200,__('Quantity transfred to the new location successfully'));
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
        $location = $this->locations_service->update($id,$request);
        return jsonResponse(['location'=>$location],200,__('Location updated successfully'));
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = $this->locations_service->find($id);
        if (!$location) {
            return response()->json(['message' => __('Location already deleted!'),  'success' => false]);
        } else {
             
            
            try {
                $this->locations_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }
 
            return response()->json(['message' => __('Location has been deleted!'),  'success' => true]);
        }
 
        return back();
    }


    public function allCitiesByCountry(Request $request)
    {
        return  $this->locations_service->allCitiesByCountry($request->id);
      
    }
    
}
