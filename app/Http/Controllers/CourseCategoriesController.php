<?php

namespace App\Http\Controllers;

use App\Domains\Courses\Services\CourseService;
use App\Domains\Courses\Services\CourseCategoryService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class CourseCategoriesController extends Controller
{
    protected $course_category_service;  
    protected $course_service; 
    protected $permission_service;
    public function __construct( CourseService $course_service , CourseCategoryService $course_category_service )
    {
        $this->course_service                = $course_service;
        $this->course_category_service       = $course_category_service;
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
       if ($request->ajax()) {

           $data = $this->course_category_service->prepare_data_table();
         
               return Datatables::of($data)
                   ->addIndexColumn()
                   ->addColumn('courses', function($row){
                        $link =' <a href="'.route('courses.show',$row->id).'"  class="edit" title="'.__('Courses').'" data-toggle="tooltip">'.$row->courses_count.'</i>';
                        return $link;
                    })
                   
                   ->addColumn('actions', function($row){

                       $permissions      =  get_user_permission();
                       $modules_ids      = $permissions[0]['modules_ids'];
                       
                       $btn ="";
                       if(in_array('18/edit', $modules_ids)):
                           $btn .=' <a href="'.route('course-categories.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                       endif;
                       if(in_array('18/delete', $modules_ids)):
                           $btn .='<a href="'.route('course-categories.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                       endif;
                           return $btn;

                   })
                 
                   ->rawColumns(['actions','courses'])
                   ->make(true);
           
       } 
      
       return view('courses.categories');
   }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
 
        $category = $this->course_category_service->get_instance();
        return view('courses.category-form',compact('category'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $category = $this->course_category_service->create($request);
       return jsonResponse(['category'=>$category],200,__('Category created successfully'));
   }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $model = $this->course_category_service->find($id);
        if($model){
            $category = $this->course_category_service->entity_to_data_model($model);
            return view('courses.category-form', compact('category'));
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
        $category = $this->course_category_service->update($id,$request);
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
        $category = $this->course_category_service->find($id);
        if (!$addon) {
            return response()->json(['message' => __('Category already deleted!'),  'success' => false]);
        } else {
             
            
            try {
                $this->course_category_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }
 
            return response()->json(['message' => __('Category has been deleted!'),  'success' => true]);
        }
 
        return back();
    }

 
}
