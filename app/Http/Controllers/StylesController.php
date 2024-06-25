<?php

namespace App\Http\Controllers;

use App\Domains\Styles\Services\StylesService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class StylesController extends Controller
{
    protected $styles_service; 
   protected $permission_service;
   public function __construct( StylesService $styles_service )
   {
       $this->styles_service       = $styles_service;
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
       if ($request->ajax()) {

           $data = $this->styles_service->prepare_data_table();
         
               return Datatables::of($data)
                   ->addIndexColumn()
                   
                   ->addColumn('actions', function($row){

                       $permissions      =  get_user_permission();
                       $modules_ids      = $permissions[0]['modules_ids'];
                       
                       $btn ="";
                       if(in_array('7/edit', $modules_ids)):
                           $btn .=' <a href="'.route('styles.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                       endif;
                       if(in_array('7/delete', $modules_ids)):
                           $btn .='<a href="'.route('styles.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                       endif;
                           return $btn;

                   })
                 
                   ->rawColumns(['actions'])
                   ->make(true);
           
       } 
      
       return view('styles.styles');
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {

       $style = $this->styles_service->get_instance();
       return view('styles.styles-form',compact('style'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $style = $this->styles_service->create($request);
       return jsonResponse(['style'=>$style],200,__('Style created successfully'));
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
       $model = $this->styles_service->find($id);
       if($model){
           $style = $this->styles_service->entity_to_data_model($model);
           return view('styles.styles-form', compact('style'));
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
       $style = $this->styles_service->update($id,$request);
       return jsonResponse(['style'=>$style],200,__('Style updated successfully'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $style = $this->styles_service->find($id);
       if (!$style) {
           return response()->json(['message' => __('Style already deleted!'),  'success' => false]);
       } else {
            
           
           try {
               $this->styles_service->delete($id);
           } catch (\Throwable $th) {
               return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
           }

           return response()->json(['message' => __('Style has been deleted!'),  'success' => true]);
       }

       return back();
   }
}
