<?php

namespace App\Domains\Vendors\Repositories;
use App\Domains\Vendors\Entities\Vendors;
use App\Domains\Vendors\Interfaces\VendorsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  VendorsRepository extends BaseRepository implements VendorsRepositoryInterface
{

    /**
    * VendorsRepository constructor.
    *
    * @param Vendors $model
    */
    public function __construct(Vendors $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT   vendors.*,
                                    countries.name as country, 
                                    images.file as image
                                    FROM   vendors
                                    LEFT JOIN countries
                                    ON vendors.country_id = countries.id
                                    LEFT JOIN images
                                        ON vendors.id = images.imageable_id
                                        AND images.field = 'vendor' 
                                        AND images.imageable_type like'%vendors%'
                                        order by vendors.id ASC");
    }

    public function countries(){
        return DB::table('countries')->get();
    }

}
