<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
     protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function all()
    {
        return $this->model->all();
    }
  
    /**
    * @param $id
    * @return Model
    */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function delete($id)
    {
        $this->model->find($id)->delete();
    }

    public function get_instance(){
        return new $this->model();
    }

    public function update($id, $data){
        $model_id = $this->model->where('id', $id)->update ($data) ;
        return $this->find($id);
    }
}
