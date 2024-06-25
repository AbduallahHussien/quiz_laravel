<?php

namespace App\Http\Controllers;

use App\Domains\Themes\Services\ThemesService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ThemesController extends Controller
{
   protected $themes_service; 
   protected $permission_service;
   public function __construct( ThemesService $themes_service )
   {
       $this->themes_service       = $themes_service;
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
       if ($request->ajax()) {

           $data = $this->themes_service->prepare_data_table();
         
               return Datatables::of($data)
                   ->addIndexColumn()
                   
                   ->addColumn('actions', function($row){

                       $permissions      =  get_user_permission();
                       $modules_ids      = $permissions[0]['modules_ids'];
                       
                       $btn ="";
                       if(in_array('6/edit', $modules_ids)):
                           $btn .=' <a href="'.route('themes.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                       endif;
                       if(in_array('6/delete', $modules_ids)):
                           $btn .='<a href="'.route('themes.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                       endif;
                           return $btn;

                   })
                 
                   ->rawColumns(['actions'])
                   ->make(true);
           
       } 
      
       return view('themes.themes');
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {

       $theme = $this->themes_service->get_instance();
       return view('themes.themes-form',compact('theme'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $theme = $this->themes_service->create($request);
       return jsonResponse(['theme'=>$theme],200,__('Theme created successfully'));
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
       $model = $this->themes_service->find($id);
       if($model){
           $theme = $this->themes_service->entity_to_data_model($model);
           return view('themes.themes-form', compact('theme'));
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
       $theme = $this->themes_service->update($id,$request);
       return jsonResponse(['theme'=>$theme],200,__('Theme updated successfully'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $theme = $this->themes_service->find($id);
       if (!$theme) {
           return response()->json(['message' => __('Theme already deleted!'),  'success' => false]);
       } else {
            
           
           try {
               $this->themes_service->delete($id);
           } catch (\Throwable $th) {
               return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
           }

           return response()->json(['message' => __('Theme has been deleted!'),  'success' => true]);
       }

       return back();
   }
}
