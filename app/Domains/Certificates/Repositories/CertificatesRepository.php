<?php

namespace App\Domains\Certificates\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Certificates\Entities\Certificates;
use App\Domains\Certificates\Interfaces\CertificatesRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  CertificatesRepository extends BaseRepository implements CertificatesRepositoryInterface
{

    /**
    * CertificatesRepository constructor.
    *
    * @param Certificates $model
    */
    public function __construct(Certificates $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table($item_id = null){
        $where = $item_id? "WHERE certificates.painting_id = $item_id":"";
        return DB::select("SELECT certificates.* , images.file as logo
                            FROM   certificates
                            LEFT JOIN images
                                ON certificates.id = images.imageable_id
                                AND images.field = 'logo' 
                                AND images.imageable_type like'%certificates%'
                           $where
                                order by certificates.id ASC
                 ");
    }
  
    
    
  


}
