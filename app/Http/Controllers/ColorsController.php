<?php

namespace App\Http\Controllers;

use App\Domains\Colors\Services\ColorsService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ColorsController extends Controller
{   protected $colors_service; 
    protected $permission_service;
    public function __construct( ColorsService $colors_service )
    {
        $this->colors_service       = $colors_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
 
            $data = $this->colors_service->prepare_data_table();
          
                return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('actions', function($row){
 
                        $permissions      =  get_user_permission();
                        $modules_ids      = $permissions[0]['modules_ids'];
                        
                        $btn ="";
                        if(in_array('8/edit', $modules_ids)):
                            $btn .=' <a href="'.route('colors.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                        endif;
                        if(in_array('8/delete', $modules_ids)):
                            $btn .='<a href="'.route('colors.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                        endif;
                            return $btn;
 
                    })
                  
                    ->rawColumns(['actions'])
                    ->make(true);
            
        } 
       
        return view('colors.colors');
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
        $color = $this->colors_service->get_instance();
        return view('colors.colors-form',compact('color'));
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $color = $this->colors_service->create($request);
        return jsonResponse(['color'=>$color],200,__('Color created successfully'));
    }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->colors_service->find($id);
        if($model){
            $color = $this->colors_service->entity_to_data_model($model);
            return view('colors.colors-form', compact('color'));
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
        $color = $this->colors_service->update($id,$request);
        return jsonResponse(['color'=>$color],200,__('Color updated successfully'));
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $color = $this->colors_service->find($id);
        if (!$color) {
            return response()->json(['message' => __('Color already deleted!'),  'success' => false]);
        } else {
             
            
            try {
                $this->colors_service->delete($id);
            } catch (\Throwable $th) {
                return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
            }
 
            return response()->json(['message' => __('Color has been deleted!'),  'success' => true]);
        }
 
        return back();
    }
}
