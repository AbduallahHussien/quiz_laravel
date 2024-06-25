<?php

namespace App\Domains\Customers\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Customers\Entities\Customers;
use App\Domains\Customers\Interfaces\CustomersRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  CustomersRepository extends BaseRepository implements CustomersRepositoryInterface
{

    /**
    * CustomersRepository constructor.
    *
    * @param Customers $model
    */
    public function __construct(Customers $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT   customers.*,
                                    countries.name as country, 
                                    images.file as image
                                    FROM   customers
                                    LEFT JOIN countries
                                    ON customers.country_id = countries.id
                                        LEFT JOIN images
                                            ON customers.id = images.imageable_id
                                            AND images.field = 'customer' 
                                            AND images.imageable_type like'%customers%'
                                            order by customers.id ASC");
    }

    public function countries(){
        return DB::table('countries')->get();
    }


    public function findCustomerByNameOrPhone($term){
        return DB::select("select
                                id,
                                full_name
                            from
                                customers
                            where
                                full_name like '%$term%'
                                or phone like '$term'");
    }

}
