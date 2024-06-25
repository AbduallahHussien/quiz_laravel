<?php

namespace App\Domains\History\Services;

use App\Domains\History\Interfaces\HistoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class HistoryService{

    private $history_respository;

    public function __construct(HistoryRepositoryInterface $history_respository)
	{
        $this->history_respository = $history_respository;       
	}

    public function create($model, $model_id, $action, $description){
        $this->history_respository->insert($model, $model_id, $action, $description);
    }
 
   


    public function prepare_data_table($module,$model_id){
        return $this->history_respository->prepare_data_table($module,$model_id);
    }


   
}
