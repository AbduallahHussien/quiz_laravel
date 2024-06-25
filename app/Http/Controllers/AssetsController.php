<?php

namespace App\Http\Controllers;

use App\Domains\Assets\Services\AssetService;
use App\Domains\Assets\Services\AssetCategoryService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    protected $asset_service; 
    protected $asset_category_service;  
    protected $permission_service;
    public function __construct(
        AssetCategoryService $asset_category_service ,
        AssetService $asset_service
    )
    {
        $this->asset_service                = $asset_service;
        $this->asset_category_service       = $asset_category_service;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request, $id)
   {
    if ($request->ajax()) {

        $data = $this->asset_service->prepare_data_table($id);
      
            return Datatables::of($data)
                ->addIndexColumn()
                
                ->addColumn('actions', function($row){

                    $permissions      =  get_user_permission();
                    $modules_ids      = $permissions[0]['modules_ids'];
                    
                    $btn ="";
                    if(in_array('20/edit', $modules_ids)):
                        $btn .=' <a href="'.route('assets.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                    endif;
                    if(in_array('20/view', $modules_ids)):
                        $btn .='<a href="'.route('assets-owners',$row->id).'" data-id="'.$row->id.'" class="action-btn assign assign-icon" title="'.__('Assign to Employee').'" data-toggle="tooltip"><i class="fas fa-user"></i></a>';
                    endif;
                    if(in_array('20/delete', $modules_ids)):
                        $btn .='<a href="'.route('assets.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                    endif;
                        return $btn;

                })
              
                ->rawColumns(['actions'])
                ->make(true);
        
    } 
    $category = $this->asset_category_service->find($id);
    return view('assets.assets',compact('category'));
   }
    
   
   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function owners($id)
    {
        $model = $this->asset_service->find($id);
        if($model){
             $unassigned_quantity = $this->asset_service->unassigned_quantity($model->quantity, $id);
             $categories = $this->asset_category_service->all();
             $asset = $this->asset_service->entity_to_data_model($model);
             $category = $this->asset_category_service->find($asset->category_id);
             $owners = $this->asset_service->owners();
             return view('assets.asset-owners', compact('asset','categories','category','owners','unassigned_quantity'));
        }
      
    }  


   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function form($id)
    {
        $asset = $this->asset_service->get_instance();
        $item['category_id'] =  $id;
        $category = $this->asset_category_service->find($id);
        return view('assets.asset-form',compact('asset','category'));
      
    }
    
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $asset = $this->asset_service->create($request);
       return jsonResponse(['asset'=>$asset],200,__('Asset created successfully'));
   }


    /**
    * Assign a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function assign(Request $request,$asset_id)
    {
        $asset = $this->asset_service->assign($request, $asset_id);
        return jsonResponse(['asset'=>$asset],200,__('Quantity assigned to the new owner successfully'));
    }

    /**
    * Assign a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function unassign(Request $request,$assiged_asset_id)
    {
        $asset = $this->asset_service->unassign($assiged_asset_id);
        return response()->json(['message' => __('Asset assignment has been deleted!'),  'success' => true]);
    }
 

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $model = $this->asset_service->find($id);
       if($model){
            $categories = $this->asset_category_service->all();
            $asset = $this->asset_service->entity_to_data_model($model);
            $category = $this->asset_category_service->find($asset->category_id);
            return view('assets.asset-form', compact('asset','categories','category'));
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
       $asset = $this->asset_service->update($id,$request);
       return jsonResponse(['asset'=>$asset],200,__('Asset updated successfully'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $asset = $this->asset_service->find($id);
       if (!$asset) {
           return response()->json(['message' => __('Asset already deleted!'),  'success' => false]);
       } else {
            
           
           try {
               $this->asset_service->delete($id);
           } catch (\Throwable $th) {
               return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
           }

           return response()->json(['message' => __('Asset has been deleted!'),  'success' => true]);
       }

       return back();
   }


    /**
     * find items by barcode or name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findAssets(Request $request)
    {
 
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $items = $this->asset_service->findAssetsByName($term);

        $formatted_items = [];

        foreach ($items as $item) {
            $formatted_items[] = ['id' => $item->id, 'text' => $item->title];
        }

        return \Response::json($formatted_items);
    }


    
}
