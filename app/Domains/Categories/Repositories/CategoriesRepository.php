<?php

namespace App\Domains\Categories\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Categories\Entities\Categories;
use App\Domains\Categories\Interfaces\CategoriesRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  CategoriesRepository extends BaseRepository implements CategoriesRepositoryInterface
{

    /**
    * CategoriesRepository constructor.
    *
    * @param Categories $model
    */
    public function __construct(Categories $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table($type){

        return DB::select("SELECT categories.*, c.name as parent,
        images.file as logo
        FROM   categories
        LEFT JOIN categories c on c.id = categories.parent_id
            LEFT JOIN images
                ON categories.id = images.imageable_id
                AND images.field = 'logo' 
                 AND images.imageable_type like'%categories%'
                 where categories.type like '$type'
                 order by categories.id ASC
                 ");
    }
  
    public function all_by_type($type){
        return $this->model->where('type',$type)->get();
    }

    public function findCategoryBySlug($slug){
        $query = "SELECT categories.*, c.name as parent,
        images.file as logo
        FROM   categories
        LEFT JOIN categories c on c.id = categories.parent_id
        LEFT JOIN images
                ON categories.id = images.imageable_id
                AND images.field = 'logo' 
                AND images.imageable_type like'%categories%'
        WHERE categories.slug = ?";

        $category = DB::select($query, [$slug]);

        return $category;
    }
    public static function SidebarCategories(){
                $query = "
                SELECT categories.* , COUNT(paintings.id) as count
                FROM categories
                LEFT JOIN paintings on paintings.category_id = categories.id
                WHERE categories.type = 'stock'
                
                GROUP BY categories.id,categories.name, categories.name_ar,categories.description_ar,categories.description,categories.slug,categories.parent_id,categories.type,categories.created_at,categories.updated_at ";

        return DB::select($query);

    }

    public static function getParentCat($limit){
        $query = "SELECT 
        categories.*
        FROM categories
        where categories.parent_id IS NULL
        LIMIT ? ";

        $categories = DB::select($query, [$limit]);

        return $categories;
    }

    public static function getSubCat($id){
        $query = "SELECT 
        categories.*
        FROM categories
        where categories.parent_id = ? ";

        $categories = DB::select($query, [$id]);

        return $categories;
    }
    
    
    
    
  


}
