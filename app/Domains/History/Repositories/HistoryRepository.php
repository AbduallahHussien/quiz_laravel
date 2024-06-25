<?php

namespace App\Domains\History\Repositories;

use Illuminate\Support\Facades\Storage;
use App\Domains\History\Entities\History;
use App\Domains\History\Interfaces\HistoryRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  HistoryRepository extends BaseRepository implements HistoryRepositoryInterface
{

    /**
    * AddonsRepository constructor.
    *
    * @param History $model
    */
    public function __construct(History $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table($model,$model_id){

        return DB::select("select
                                history.id,
                                history.action,
                                history.description,
                                history.created_at as date,
                                users.name as author
                            from
                                history
                            inner join users on
                                history.user_id = users.id
                            where model = '$model' and model_id = $model_id");
    }

    public function insert($model_name, $model_id, $action, $description){
        // Create a new history record
        $this->model::create([
            'action' => $action,
            'model' => $model_name,
            'model_id' => $model_id,
            'description' => $description,
            'user_id' => auth()->user()->id,
        ]);
        
    }
  
    
    
  


}
