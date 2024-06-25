<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Settings\Services\SettingsService;

use DataTables;


class SettingsController extends Controller
{
    protected $settings_service;
    public function __construct(SettingsService $settings_service)
    {
        $this->settings_service = $settings_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    
        $settings = $this->settings_service->prepare_data_table(); 
        $data = array();
        foreach( $settings as $row):
            $data[$row->name]= $row->value;
        endforeach;
                 
        return view('settings.settings',compact('data'));
    }
    public function surveys(Request $request)
    {   
        $settings = $this->settings_service->prepare_data_table(); 
        return view('settings.surveys',compact('settings'));
    }


 
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
     
   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setting = $this->settings_service->create($request);
        return jsonResponse(['setting'=>$setting],200,__('New settings have been saved'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       return view('settings.settings-form');
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
        $model = $this->settings_service->find($id);
        if($model){
            $setting = $this->settings_service->entity_to_data_model($model);
            return view('settings.settings-form',compact('setting'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $settings = $this->settings_service->update($request);
       return jsonResponse(['settings'=>$settings],200,__('Settings updated successfully'));

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $settings = $this->settings_service->find($id);
        if (!$settings) {
            return response()->json(['message' => __('Settings already deleted!'), 'success' => false]);
        } else {
            $this->settings_service->delete($id);

            return response()->json(['message' => __('Settings has been deleted!'), 'success' => true]);
        }

        return back();
    }
}
