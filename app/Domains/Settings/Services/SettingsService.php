<?php

namespace App\Domains\Settings\Services;

use App\Domains\Settings\Interfaces\SettingsRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

Class SettingsService{

    private $settings_respository;
    private $image_respository;

    public function __construct(SettingsRepositoryInterface $settings_respository,
    ImageRepositoryInterface $image_respository
    )
	{
        $this->settings_respository = $settings_respository;
        $this->image_respository = $image_respository;
       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $settings = $this->settings_respository->create($data_model);
        if ($request->logo) {
            $this->image_respository->upload($request->logo,  $settings, "logo","logo");
        }

        if ($request->settings_logo) {
            $this->image_respository->upload($request->settings_logo,  $settings, "logo","logo");
        }

        return $settings;

    }
    
    public function get_survey_settings(){
        $this->settings_respository->get_survey_settings(); 

    }
    public function save_survey_settings($request){
        $this->settings_respository->save_survey_settings($request); 

    }
    
   
   
    public function update($request){

        if($request->has('logo')){ 
            $image_name = time() . rand() . '.' . $request->logo->getClientOriginalExtension();
            // Upload image
            $request->logo->move(public_path('images'), $image_name); 
            $this->settings_respository->update_settings('logo',$image_name);
        }
        if($request->has('public_logo')){ 
            $image_name = time() . rand() . '.' . $request->public_logo->getClientOriginalExtension();
            // Upload image
            $request->public_logo->move(public_path('images'), $image_name); 
            $this->settings_respository->update_settings('public_logo',$image_name);
        }
        if($request->has('qr_logo')){ 
            $image_name = time() . rand() . '.' . $request->qr_logo->getClientOriginalExtension();
            // Upload image
            $request->qr_logo->move(public_path('images'), $image_name); 
            $this->settings_respository->update_settings('qr_logo',$image_name);
        }
      
        

        if($request->has('title')){
            $this->settings_respository->update_settings('title',$request->title);  
        }
      
        if($request->has('facebook')){
            $this->settings_respository->update_settings('facebook',$request->facebook);  
        }
        if($request->has('twitter')){
            $this->settings_respository->update_settings('twitter',$request->twitter);  
        }
        if($request->has('pinterest')){
            $this->settings_respository->update_settings('pinterest',$request->pinterest);  
        }
        if($request->has('address')){
            $this->settings_respository->update_settings('address',$request->address);  
        }
        if($request->has('email')){
            $this->settings_respository->update_settings('email',$request->email);  
        }
        if($request->has('phone')){
            $this->settings_respository->update_settings('phone',$request->phone);  
        }
        if($request->has('altitude')){
            $this->settings_respository->update_settings('altitude',$request->altitude);  
        }
        if($request->has('longitude')){
            $this->settings_respository->update_settings('longitude',$request->longitude);  
        }
        if($request->has('terms_page')){
            $this->settings_respository->update_settings('terms_page',$request->terms_page);  
        }
        if($request->has('vendor_selling_percentage')){
            $this->settings_respository->update_settings('vendor_selling_percentage',$request->vendor_selling_percentage);  
        }
        if($request->has('language')){
            $this->settings_respository->update_settings('language',$request->language);  
        }
        
      
        if($request->has('footer')){
            $this->settings_respository->update_settings('footer',$request->footer);  
        }
        Session::put('applocale',$request->language);

        if($request->has('who_are_you')){
            $sanitizedValues = preg_replace('/background-color\s*:\s*[^;]+;/', '', $request->who_are_you); 

            DB::table('settings')
                    ->where('name','who_are_you')
                    ->update([
                        'value' =>$sanitizedValues,
                ]); 
                
        }
        if($request->has('our_vision')){
            $sanitizedValues = preg_replace('/background-color\s*:\s*[^;]+;/', '', $request->our_vision); 
            DB::table('settings')
                    ->where('name','our_vision')
                    ->update([
                        'value' =>$sanitizedValues,
                ]); 
                
        }
        if($request->has('our_mission')){
                $sanitizedValues = preg_replace('/background-color\s*:\s*[^;]+;/', '', $request->our_mission);          
            
                DB::table('settings')
                    ->where('name','our_mission')
                    ->update([
                        'value' =>$sanitizedValues,
                ]); 
                
        }

        if($request->has('our_values')){
            $sanitizedValues = preg_replace('/background-color\s*:\s*[^;]+;/', '', $request->our_values);            DB::table('settings')
                    ->where('name','our_values')
                    ->update([
                        'value' => $sanitizedValues,
                ]); 
                
        }
        
        
       
       

            
        

    }

    public function get_instance(){
        return $this->settings_respository->get_instance();
    }

    public function prepare_data_table(){
        return $this->settings_respository->prepare_data_table();
    }

    public function all(){
        return $this->settings_respository->all();
    }

    public function find($id){
        return $this->settings_respository->find($id);
    }

    public function delete($id){
        $this->settings_respository->delete($id);
    }

    private function request_to_data_model($request){
        if($request->settings_name){
            return [
                "name" => $request->name,
                "value" => $request->value,
               
            ];
        }else{
            return [
                "name" => $request->name,
                "value" => $request->value,
               
            ];
        }

    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "name" => $entity->name,
            "value" => $entity->value,
            "logo" => $entity->images->where('field','logo')->first(),
           
        ];
    }
   
}
