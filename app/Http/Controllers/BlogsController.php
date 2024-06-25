<?php

namespace App\Http\Controllers;

use App\Domains\Blogs\Services\PostsService; 
use App\Domains\Categories\Services\CategoriesService;
use App\Domains\Permissions\Services\PermissionService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BlogsController extends Controller
{
    protected $posts_service; 
    protected $permission_service;
    protected $categories_service; 
    public function __construct(
         PostsService $posts_service , 
         PermissionService $permission_service,
         CategoriesService $categories_service, 
    )
    {
        $this->posts_service       = $posts_service;
        $this->permission_service = $permission_service;
        $this->categories_service      = $categories_service;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->posts_service->prepare_data_table();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){
                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('21/edit', $modules_ids)):
                            $btn .=' <a href="'.route('posts.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('21/delete', $modules_ids)):
                            $btn .='<a href="'.route('posts.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;
                    })
                    ->addColumn('lang', function($row){
                        $language = '<span class="badge bg-success">'.__("English").'</span>';
                        if($row->language == 'ar'){
                            $language = '<span class="badge bg-warning text-dark">'.__("Arabic").'</span>';
                        }
                        return $language;
                    })
                    ->rawColumns(['actions','lang'])
                    ->make(true);
        } 
       
        return view('posts.posts');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $post = $this->posts_service->get_instance();
        $categories = $this->categories_service->all_by_type('posts');
        return view('posts.posts-form',compact('post','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $this->posts_service->create($request);
        return jsonResponse(['post'=>$post],200,__('Post created successfully'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->posts_service->find($id);
        if($model){
            $post = $this->posts_service->entity_to_data_model($model);
            $categories = $this->categories_service->all_by_type('posts');
            return view('posts.posts-form', compact('post','categories'));
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
        $post = $this->posts_service->update($id,$request);
        return jsonResponse(['post'=>$post],200,__('Post updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->posts_service->find($id);
        if (!$post) {
            return response()->json(['message' => __('Post already deleted!'),  'success' => false]);
        } else {
            try {
                $this->posts_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }

            return response()->json(['message' => __('Post has been deleted!'),  'success' => true]);
        }

        return back();
    }
}
