<?php

namespace App\Http\Controllers;

use App\Domains\Addons\Services\ItemsService;
use App\Domains\Addons\Services\AddonsService;
use App\Domains\Locations\Services\LocationsService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class AddonsItemsController extends Controller
{
   protected $locations_service;
   protected $items_service; 
   protected $addons_service;  
   protected $permission_service;
   public function __construct(AddonsService $addons_service ,LocationsService $locations_service , ItemsService $items_service )
   {
       $this->items_service       = $items_service;
       $this->locations_service       = $locations_service;
       $this->addons_service       = $addons_service;
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       
   }
/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function form($id)
    {
        $locations = $this->locations_service->all();
        $item = $this->items_service->get_instance();
        $item['category_id'] =  $id;
        $category = $this->addons_service->find($id);
        return view('addons_items.items-form',compact('item','locations','category'));
      
    }
   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $item = $this->items_service->create($request);
       return jsonResponse(['item'=>$item],200,__('Item created successfully'));
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request , $id)
   {
    if ($request->ajax()) {

        $data = $this->items_service->prepare_data_table($id);
      
            return Datatables::of($data)
                ->addIndexColumn()
                
                ->addColumn('actions', function($row){

                    $permissions      =  get_user_permission();
                    $modules_ids      = $permissions[0]['modules_ids'];
                    
                    $btn ="";
                    if(in_array('11/edit', $modules_ids)):
                        $btn .=' <a href="'.route('addonsItems.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                    endif;
                    if(in_array('11/delete', $modules_ids)):
                        $btn .='<a href="'.route('addonsItems.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                    endif;
                        return $btn;

                })
              
                ->rawColumns(['actions'])
                ->make(true);
        
    } 
    $category = $this->addons_service->find($id);
    return view('addons_items.items',compact('category'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $model = $this->items_service->find($id);
       if($model){
            $categories = $this->addons_service->all();
            $locations = $this->locations_service->all();
            $item = $this->items_service->entity_to_data_model($model);
            $category = $this->addons_service->find($item->category_id);
            return view('addons_items.items-form', compact('item','categories','locations','category'));
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
       $item = $this->items_service->update($id,$request);
       return jsonResponse(['item'=>$item],200,__('Item updated successfully'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $item = $this->items_service->find($id);
       if (!$item) {
           return response()->json(['message' => __('Item already deleted!'),  'success' => false]);
       } else {
            
           
           try {
               $this->items_service->delete($id);
           } catch (\Throwable $th) {
               return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
           }

           return response()->json(['message' => __('Item has been deleted!'),  'success' => true]);
       }

       return back();
   }


    /**
     * find items by barcode or name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findItems(Request $request)
    {
 
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $location_id = null;
        if($request->has('location_id')){
            $location_id = $request->location_id;
        }

        $items = $this->items_service->findIemsByNameOrBarcode($term,$location_id);

        $formatted_items = [];

        foreach ($items as $item) {
            $formatted_items[] = ['id' => $item->id, 'text' => $item->name, 'price_sar' => $item->price,  'price' => $item->price, 'price_euro' => $item->price_euro, 'quantity' => isset($item->quantity) ? $item->quantity:0];
        }

        return \Response::json($formatted_items);
    }
}
