<?php

namespace App\Domains\Suppliers\Repositories;
use App\Domains\Suppliers\Entities\Suppliers;
use App\Domains\Suppliers\Interfaces\SuppliersRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  SuppliersRepository extends BaseRepository implements SuppliersRepositoryInterface
{

    /**
    * SuppliersRepository constructor.
    *
    * @param Suppliers $model
    */
    public function __construct(Suppliers $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT   suppliers.*,
                                    countries.name as country, 
                                    images.file as image
                                    FROM   suppliers
                                    LEFT JOIN countries
                                    ON suppliers.country_id = countries.id
                                    LEFT JOIN images
                                        ON suppliers.id = images.imageable_id
                                        AND images.field = 'vendor' 
                                        AND images.imageable_type like'%suppliers%'
                                        order by suppliers.id ASC");
    }

    public function countries(){
        return DB::table('countries')->get();
    }

}
