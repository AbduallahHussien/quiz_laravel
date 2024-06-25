<?php

namespace App\Http\Controllers;

use App\Domains\Addons\Services\AddonsService;
use App\Domains\Addons\Services\ItemsService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class AddonsController extends Controller
{
    protected $addons_service;  
    protected $items_service; 
   protected $permission_service;
   public function __construct( ItemsService $items_service , AddonsService $addons_service )
   {
        $this->items_service       = $items_service;
       $this->addons_service       = $addons_service;
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
       if ($request->ajax()) {

           $data = $this->addons_service->prepare_data_table();
         
               return Datatables::of($data)
                   ->addIndexColumn()
                   ->addColumn('addons', function($row){
                    $a ="";
                    $addons = $this->items_service->prepare_data_table($row->id);
                 
                    $a .=' <a href="'.route('addonsItems.show',$row->id).'"  class="edit" title="'.__('Addons').'" data-toggle="tooltip">'.count($addons).'</i>';

                        return $a;
                    })
                   
                   ->addColumn('actions', function($row){

                       $permissions      =  get_user_permission();
                       $modules_ids      = $permissions[0]['modules_ids'];
                       
                       $btn ="";
                       if(in_array('11/edit', $modules_ids)):
                           $btn .=' <a href="'.route('addons.edit',$row->id).'"  class="edit" title="'.__('Edit').'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i>';
                       endif;
                       if(in_array('11/delete', $modules_ids)):
                           $btn .='<a href="'.route('addons.destroy',$row->id).'" data-id="'.$row->id.'" class="delete delete-icon" title="'.__('Delete').'" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
                       endif;
                           return $btn;

                   })
                 
                   ->rawColumns(['actions','addons'])
                   ->make(true);
           
       } 
      
       return view('addons.addons');
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {

       $addon = $this->addons_service->get_instance();
       return view('addons.addons-form',compact('addon'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $addon = $this->addons_service->create($request);
       return jsonResponse(['addon'=>$addon],200,__('Addon created successfully'));
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
       $model = $this->addons_service->find($id);
       if($model){
           $addon = $this->addons_service->entity_to_data_model($model);
           return view('addons.addons-form', compact('addon'));
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
       $addon = $this->addons_service->update($id,$request);
       return jsonResponse(['addon'=>$addon],200,__('Addon updated successfully'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $addon = $this->addons_service->find($id);
       if (!$addon) {
           return response()->json(['message' => __('Addon already deleted!'),  'success' => false]);
       } else {
            
           
           try {
               $this->addons_service->delete($id);
           } catch (\Throwable $th) {
               return response()->json(['message' => __('Please delete all sub related entities first!'), 'success' => false]);
           }

           return response()->json(['message' => __('Addon has been deleted!'),  'success' => true]);
       }

       return back();
   }
}
