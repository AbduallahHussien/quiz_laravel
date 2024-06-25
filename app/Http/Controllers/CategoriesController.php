<?php

namespace App\Http\Controllers;

use App\Domains\Categories\Services\CategoriesService;
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected $categories_service; 
    protected $permission_service;
    public function __construct( CategoriesService $categories_service , PermissionService $permission_service )
    {
        $this->categories_service       = $categories_service;
        $this->permission_service = $permission_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = 'stock';
        if($request->has('type')){
            $type = $request->type;
        }

        $target_name = 'Stock';
        $target_url= 'javascript:void(0)';
        if($type == 'artists'){
            $target_name = 'Artists';
            $target_url = route('artists.index');
        }else if($type == 'posts'){
            $target_name = 'Posts';
            $target_url = route('posts.index');
        }

        if ($request->ajax()) {

            $data = $this->categories_service->prepare_data_table($type);
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row)  use ($type){

                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('5/edit', $modules_ids)):
                            $btn .=' <a href="'.route('categories.edit',$row->id).'?type='.$type.'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('5/delete', $modules_ids)):
                            $btn .='<a href="'.route('categories.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;

                    })
                  
                    ->rawColumns(['actions'])
                    ->make(true);
            
        } 
       
        return view('categories.categories',compact('type','type','target_name','target_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = 'stock';
        if($request->has('type')){
            $type = $request->type;
        }
        $target_url= 'javascript:void(0)';
        if($type == 'artists'){
            $target_url = route('artists.index');
        }else if($type == 'posts'){
            $target_url = route('posts.index');
        }

        $categories = $this->categories_service->all_by_type($type);
        $category = $this->categories_service->get_instance();
        return view('categories.categories-form',compact('category','categories','type','target_url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = $this->categories_service->create($request);
        return jsonResponse(['category'=>$category],200,__('Category created successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $model = $this->categories_service->find($id);
        if($model){
            $type = 'stock';
            if($request->has('type')){
                $type = $request->type;
            }

            $target_url= 'javascript:void(0)';
            if($type == 'artists'){
                $target_url = route('artists.index');
            }else if($type == 'posts'){
                $target_url = route('posts.index');
            }

            
            $categories = $this->categories_service->all_by_type($type);
            $category = $this->categories_service->entity_to_data_model($model);
            return view('categories.categories-form', compact('category','categories','type','target_url'));
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
        $category = $this->categories_service->update($id,$request);
        return jsonResponse(['category'=>$category],200,__('Category updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categories_service->find($id);
        if (!$category) {
            return response()->json(['message' => __('Category already deleted!'),  'success' => false]);
        } else {
             
            
            try {
                $this->categories_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }

            return response()->json(['message' => __('Category has been deleted!'),  'success' => true]);
        }

        return back();
    }
}
