<?php

namespace App\Domains\Blogs\Repositories;
use App\Domains\Blogs\Entities\Posts;
use App\Domains\Blogs\Interfaces\PostsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  PostsRepository extends BaseRepository implements PostsRepositoryInterface
{

    /**
    * PostsRepository constructor.
    *
    * @param Posts $model
    */
    public function __construct(Posts $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table(){

        return DB::select("SELECT   posts.*,
                                    categories.name as category,
                                    images.file as image
                                    FROM   posts
                                    INNER JOIN categories
                                    on posts.category_id = categories.id
                                    LEFT JOIN images
                                        ON posts.id = images.imageable_id
                                        AND images.field = 'posts' 
                                        AND images.imageable_type like'%posts%'
                                        order by posts.id ASC");
    }
    public function featuredPosts($limit){
        $lang = session()->has('language') && session('language') === 'ar' ? 'ar':'en';

                return DB::select("SELECT   
                                    posts.*,
                                    images.file as image
                                    FROM   posts
                                    LEFT JOIN images
                                        ON posts.id = images.imageable_id
                                        AND images.field = 'post' 
                                        AND images.imageable_type like'%Posts%'
                                    where language = '$lang'
                                    order by posts.id DESC
                                    LIMIT $limit
                                ");
    }


    public function PostsWithPaginate($perPage) {
        $lang = session()->has('language') && session('language') === 'ar' ? 'ar':'en';
        $query = DB::table('posts')
            ->where('language',$lang)
            ->leftJoin('images', function ($join) {
                $join->on('posts.id', '=', 'images.imageable_id');
                $join->where('images.field', '=', 'post');
                $join->where('images.imageable_type', 'LIKE', '%Posts%'); // Fixed LIKE condition
            })
            ->leftJoin('categories', function ($join) {
                $join->on('categories.id', '=', 'posts.category_id');
            })
            ->select('posts.*', 'images.file as image','categories.name as category','categories.slug as category_slug');
    
        return $query->paginate($perPage);
    }

    public function findPostBySlug($slug){
        $query = "SELECT 
        posts.*,categories.name as category_name,
        images.file as image
        FROM posts
        INNER JOIN categories on categories.id =  posts.category_id
        LEFT JOIN images
        ON posts.id = images.imageable_id
        AND images.field = 'post' 
        AND images.imageable_type LIKE '%Post%'
        WHERE posts.slug = ?";

        $post = DB::select($query, [$slug]);
        return $post;
    }
    

}
