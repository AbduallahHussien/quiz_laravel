<?php

namespace App\Domains\Settings\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Settings\Entities\Settings;
use App\Domains\Settings\Interfaces\SettingsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  SettingsRepository extends BaseRepository implements SettingsRepositoryInterface
{

    /**
    * SettingsRepository constructor.
    *
    * @param Settings $model
    */
    public function __construct(Settings $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT settings.*,
        images.file as logo
        FROM   settings
            LEFT JOIN images
                ON settings.id = images.imageable_id
                AND images.field = 'logo' 
                 AND images.imageable_type like'%settings%'
                 order by settings.id ASC");
    }
    public function update_settings($key,$value){
        
                $query="
                    UPDATE settings
                    SET value = '$value'
                    WHERE name='".$key."'";
               return(DB::update($query));       
    }

    public function save_survey_settings($request){
        
                    DB::table('settings')
                        ->where('name','is_enable_coupons')
                        ->update([
                            'value' => $request->is_enable_coupons,
                    ]);    
                    DB::table('settings')
                    ->where('name','is_enable_foodics')
                    ->update([
                        'value' => $request->is_enable_foodics,
                ]);
    }
    
  


}
