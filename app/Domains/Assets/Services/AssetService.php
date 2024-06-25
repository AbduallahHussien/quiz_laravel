<?php

namespace App\Domains\Assets\Services;

use App\Domains\Assets\Interfaces\AssetRepositoryInterface;
use App\Domains\User\Interfaces\UserRepositoryInterface;
use App\Domains\History\Services\HistoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class AssetService{

    private $asset_repository;

    public function __construct(
        AssetRepositoryInterface $asset_repository,
        UserRepositoryInterface $user_repository,
        HistoryService $history_service,
    )
	{
        $this->asset_repository = $asset_repository;
        $this->user_repository = $user_repository;
        $this->history_service = $history_service;
	}

    public function create($request){
        $data_model = $this->request_to_data_model($request);
        $asset = $this->asset_repository->create($data_model);
        return $asset;
    }

    public function unassigned_quantity($quantity, $asset_id){
        $total_assigned = $this->asset_repository->total_assigned($asset_id);
        return max(($quantity - $total_assigned),0);
    }
    
    
    public function assign($request, $asset_id){
        $this->asset_repository->assign($asset_id, $request->owner_id, $request->quantity);
        $this->history_service->create('assets', $asset_id, 'assign', $request->quantity.' items are assigned to user_id '. $request->owner_id);
    }
    

    public function owners(){
        return $this->user_repository->all();
    }
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $asset = $this->asset_repository->update($id,$data_model);
        $this->history_service->create('assets', $id, 'update', 'Asset data updates '.http_build_query($data_model));

        return $asset;
    }
    public function get_instance(){
        return $this->asset_repository->get_instance();
    }

    public function prepare_data_table($id){
        return $this->asset_repository->prepare_data_table($id);
    }

    public function all(){
        return $this->asset_repository->all();
    }

    public function find($id){
        return $this->asset_repository->find($id);
    }

    public function findAssetsByName($term){
        return $this->asset_repository->findAssetsByName($term);
    }

    public function delete($id){
        $asset = $this->find($id);
        $this->asset_repository->delete($id);
    }
    

    public function unassign($id){

        $record = $this->asset_repository->unassign($id);
        $this->history_service->create('assets', $id, 'unassign','Asset is unassigned from user_id '. $record->user_id);

    }
    

    private function request_to_data_model($request){
       
            $data =  [
                "name" => $request->name,
                "name_ar" => $request->name_ar,
                'quantity'=> $request->quantity,
                'category_id'=> $request->category_id,
                'description'=> $request->description,
                'description_ar'=> $request->description_ar,
            ];
            return $data;
    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "name" => $entity->name,
            "name_ar" => $entity->name_ar,
            'category_id'=> $entity->category_id,
            'description'=> $entity->description,
            'description_ar'=> $entity->description_ar,
            'quantity'=> $entity->quantity,
            'owners'=> $entity->owners,
        ];
    }
   
}
