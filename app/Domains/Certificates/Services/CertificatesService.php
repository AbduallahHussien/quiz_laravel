<?php

namespace App\Domains\Certificates\Services;

use App\Domains\Certificates\Interfaces\CertificatesRepositoryInterface;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

Class CertificatesService{

    private $certificates_respository;
    private $image_repository;

    public function __construct(CertificatesRepositoryInterface $certificates_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->certificates_respository = $certificates_respository;
        $this->image_repository = $image_repository;
       
	}

    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $certificate = $this->certificates_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $certificate, "logo","logo");
        }
        return $certificate;

    }
    
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $certificates = $this->certificates_respository->update($id,$data_model);
        if ($request->image) {
            $this->image_repository->update_field($certificates , "logo","logo",$request->image);
        }
        return $certificates;
    }

    public function get_instance(){
        return $this->certificates_respository->get_instance();
    }

    public function prepare_data_table($item_id){
        return $this->certificates_respository->prepare_data_table($item_id);
    }

    public function all(){
        return $this->certificates_respository->all();
    }

    public function find($id){
        return $this->certificates_respository->find($id);
    }

    public function delete($id){
        $this->certificates_respository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                "name" => $request->name,
                "date" => $request->date,
                "source" => $request->source,
                "description" => $request->description,               
                "painting_id" => $request->painting_id,               
            ];
      

    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "name" => $entity->name,
            "date" => $entity->date,
            "source" => $entity->source,
            "description" => $entity->description,
            "image" => $entity->images->where('field','logo')->first(),
            "painting_id" =>  $entity->painting_id,
        ];
    }
   
}
