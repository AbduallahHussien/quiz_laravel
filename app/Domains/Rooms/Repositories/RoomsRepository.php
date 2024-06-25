<?php

namespace App\Domains\Rooms\Repositories;
use App\Domains\Rooms\Entities\Rooms;
use App\Domains\Rooms\Interfaces\RoomsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  RoomsRepository extends BaseRepository implements RoomsRepositoryInterface
{

    /**
    * VendorsRepository constructor.
    *
    * @param Rooms $model
    */
    public function __construct(Rooms $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT   rooms.*,
                                    images.file as image
                                    FROM   rooms
                                    LEFT JOIN images
                                        ON rooms.id = images.imageable_id
                                        AND images.field = 'rooms' 
                                        AND images.imageable_type like'%rooms%'
                                        order by rooms.id ASC");
    }


    public function findRoomsByName($term){
        return DB::select("select
                                id,
                                name
                            from
                                rooms
                            where
                                name like '%$term%'");
    }

}
