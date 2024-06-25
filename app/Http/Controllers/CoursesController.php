<?php

namespace App\Http\Controllers;

use App\Domains\Courses\Services\CourseService;
use App\Domains\Courses\Services\CourseCategoryService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    protected $course_service; 
    protected $course_category_service;  
    protected $permission_service;
    public function __construct(
        CourseCategoryService $course_category_service ,
        CourseService $course_service
    )
    {
        $this->course_service                = $course_service;
        $this->course_category_service       = $course_category_service;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request, $id)
   {
    if ($request->ajax()) {

        $data = $this->course_service->prepare_data_table($id);
      
            return Datatables::of($data)
                ->addIndexColumn()
                
                ->addColumn('actions', function($row){

                    $permissions      =  get_user_permission();
                    $modules_ids      = $permissions[0]['modules_ids'];
                    
                    $btn ="";
                    if(in_array('18/edit', $modules_ids)):
                        $btn .=' <a href="'.route('courses.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                    endif;
                    if(in_array('18/delete', $modules_ids)):
                        $btn .='<a href="'.route('courses.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                    endif;
                        return $btn;

                })
              
                ->rawColumns(['actions'])
                ->make(true);
        
    } 
    $category = $this->course_category_service->find($id);
    return view('courses.courses',compact('category'));
   }
  
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function form($id)
    {
        $course = $this->course_service->get_instance();
        $item['category_id'] =  $id;
        $category = $this->course_category_service->find($id);
        return view('courses.course-form',compact('course','category'));
      
    }
       /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $course = $this->course_service->create($request);
       return jsonResponse(['course'=>$course],200,__('Course created successfully'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $model = $this->course_service->find($id);
       if($model){
            $categories = $this->course_category_service->all();
            $course = $this->course_service->entity_to_data_model($model);
            $category = $this->course_category_service->find($course->category_id);
            return view('courses.course-form', compact('course','categories','category'));
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
       $course = $this->course_service->update($id,$request);
       return jsonResponse(['course'=>$course],200,__('Course updated successfully'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $course = $this->course_service->find($id);
       if (!$course) {
           return response()->json(['message' => __('Course already deleted!'),  'success' => false]);
       } else {
            
           
           try {
               $this->course_service->delete($id);
           } catch (\Throwable $th) {
               return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
           }

           return response()->json(['message' => __('Course has been deleted!'),  'success' => true]);
       }

       return back();
   }


    /**
     * find items by barcode or name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findCourses(Request $request)
    {
 
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $items = $this->course_service->findCoursesByName($term);

        $formatted_items = [];

        foreach ($items as $item) {
            $formatted_items[] = ['id' => $item->id, 'text' => $item->title];
        }

        return \Response::json($formatted_items);
    }
}
