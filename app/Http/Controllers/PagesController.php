<?php
namespace App\Http\Controllers;

use App\Domains\Pages\Services\PagesService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;


class PagesController extends Controller
{
    protected $pages_service; 
    protected $permission_service;
    public function __construct( PagesService $pages_service )
    {
        $this->pages_service       = $pages_service;
    }


    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
       if ($request->ajax()) {

           $data = $this->pages_service->prepare_data_table();
         
               return Datatables::of($data)
                   ->addIndexColumn()
                   
                   ->addColumn('actions', function($row){

                       $permissions      =  get_user_permission();
                       $modules_ids      = $permissions[0]['modules_ids'];
                       
                       $btn ='<a href="'.route('pages.show',$row->slug).'" class="action-btn" ><i class="fa fa-eye"></i></a>';
                       if(in_array('22/edit', $modules_ids)):
                           $btn .=' <a href="'.route('pages.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                       endif;
                       if(in_array('22/delete', $modules_ids)):
                           $btn .='<a href="'.route('pages.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
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
      
       return view('pages.pages');
   }


    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
 
        $page = $this->pages_service->get_instance();
        return view('pages.pages-form',compact('page'));
    }


    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $page = $this->pages_service->create($request);
       return jsonResponse(['page'=>$page],200,__('Page created successfully'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $model = $this->pages_service->find($id);
       if($model){
           $page = $this->pages_service->entity_to_data_model($model);
           return view('pages.pages-form', compact('page'));
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
       $page = $this->pages_service->update($id,$request);
       return jsonResponse(['page'=>$page],200,__('Page updated successfully'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $page = $this->pages_service->find($id);
       if (!$page) {
           return response()->json(['message' => __('Page already deleted!'),  'success' => false]);
       } else {
            
           
           try {
               $this->pages_service->delete($id);
           } catch (\Throwable $th) {
               return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
           }

           return response()->json(['message' => __('Page has been deleted!'),  'success' => true]);
       }

       return back();
   }
 

       /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = $this->pages_service->findPageBySlug($slug);
        return view('public.page',compact('page'));
    }




}
