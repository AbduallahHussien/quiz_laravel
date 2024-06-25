<?php

namespace App\Domains\Paintings\Repositories;
use Illuminate\Support\Facades\Storage;
use App\Domains\Paintings\Entities\Paintings;
use App\Domains\Paintings\Interfaces\PaintingsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class  PaintingsRepository extends BaseRepository implements PaintingsRepositoryInterface
{

    /**
    * PaintingsRepository constructor.
    *
    * @param Paintings $model
    */
    public function __construct(Paintings $model)
    {
        parent::__construct($model);
    }

    public function prepare_data_table($vendor_id = null){

        $where  = '';
        if($vendor_id){
            $where = "where vendor_id = $vendor_id";
        }
        return DB::select("
                    SELECT paintings.*,
                        IFNULL(vendors.full_name, 'Admin') AS vendor_name,
                        images.file AS logo
                    FROM paintings
                    LEFT JOIN images
                        ON paintings.id = images.imageable_id
                        AND images.field = 'logo' 
                        AND images.imageable_type LIKE '%paintings%'
                    LEFT JOIN vendors
                        ON paintings.vendor_id = vendors.id
                    $where 
                    ORDER BY paintings.id ASC;
                 ");
    }

    public function remove_image_gallery($request){
        return DB::table('images')->where(['id' => $request->id])->delete();
    }
  
    
    
    public function findPaintingsByNameOrBarcode($term){
        return DB::select("select
                                id,
                                name,
                                price,
                                price_euro
                            from
                                paintings
                            where
                                name like '%$term%'
                                or barcode like '$term' and status = 'available'");
    }


    public function isPaintingSold($id){
        $count = DB::table('sold_paintings')
                ->where('painting_id', 1)
                ->where('is_returned', 0)
                ->count('id');
        return $count;
    }

    public function findAvailablePainting($id){
        return $this->model::where('status', 'available')
        ->where('id', $id)
        ->first();
    }

    public function makePaintingAs($request){
        $data = DB::table('paintings')
        ->where('id', $request->id)
        ->update([$request->type => $request->value]); 
                
        return $data;
    }
    

    public function getPaintings($flag, $limit){
                        $query = " SELECT 
                            paintings.*,
                            images.file as logo
                            FROM   paintings
                            LEFT JOIN images
                            ON paintings.id = images.imageable_id
                            AND images.field = 'logo' 
                            AND images.imageable_type like'%paintings%'
                            WHERE paintings.status = 'available'
                          
                            ";
                        if($flag){
                            $query .= " AND  paintings.is_featured = 1 ";
                        }
                                
                        $query .="  order by paintings.id DESC
                                    limit $limit
                                ";    
                        return DB::select($query );
    }

    
    public function findPaintingBySlug($slug){
            $query = "SELECT 
            paintings.*,categories.name as category_name,
            artists.full_name,
            artists.id as artist_id,

            images.file as logo
            FROM paintings

            INNER JOIN artists on artists.id =  paintings.artist_id
            INNER JOIN categories on categories.id =  paintings.category_id
            LEFT JOIN images
            ON paintings.id = images.imageable_id
            AND images.field = 'logo' 
            AND images.imageable_type LIKE '%paintings%'
            WHERE paintings.slug = ?";

        $painting = DB::select($query, [$slug]);

        return $painting;
    }

    public function PaintingByCategoryId($id,$perPage,$search,$sort_by){
        $query = DB::table('paintings')
        ->leftJoin('images', function ($join) {
            $join->on('paintings.id', '=', 'images.imageable_id');
            $join->on('images.field', '=', DB::raw("'logo'"));
            $join->on('images.imageable_type', 'LIKE', DB::raw("'%Paintings%'"));
        })
        
        ->where(function ($query) use ($search,$id) {
            // Apply search condition if search parameter is provided
            if ($search) {
                $query->where('paintings.name', 'like', '%' . $search . '%');
            }else{
                if($id!='all-categories'){
                    $query->where('paintings.category_id', $id);
                }
            }
        })
        ->select('paintings.*', 'images.file as logo');

            // Apply sorting
            if ($sort_by&&$sort_by!='in_stock') {
              
                $query->orderBy('paintings.created_at', $sort_by);
            }
            if ($sort_by&&$sort_by=='in_stock') {
                $query->where('paintings.status', 'available');
            }

        return $query->paginate($perPage);
      
    }
    public function PaintingByArtistId($id,$limit){
        $query = "SELECT 
        paintings.*,
        images.file as logo
        FROM paintings
        INNER JOIN artists on artists.id = paintings.artist_id
        and artists.id = ?
        LEFT JOIN images
        ON paintings.id = images.imageable_id
        AND images.field = 'logo' 
        AND images.imageable_type LIKE '%paintings%'
        LIMIT ? ";

        $paintings = DB::select($query, [$id,$limit]);

        return $paintings;
    }
    public function TopRated($limit){
        $query = "SELECT 
        paintings.*,
        images.file as logo
        FROM paintings
        LEFT JOIN images
        ON paintings.id = images.imageable_id
        AND images.field = 'logo' 
        AND images.imageable_type LIKE '%paintings%'
        LIMIT ? ";

        $paintings = DB::select($query, [$limit]);

        return $paintings;
    }

    public static function cart(){
        $customer_id = \Session::get('customer_id');
            $query ="SELECT 
                        paintings.*,
                        colors.name as color,
                        images.file as logo
                        FROM paintings
                        LEFT JOIN images
                        ON paintings.id = images.imageable_id
                        AND images.field = 'logo' 
                        AND images.imageable_type LIKE '%paintings%'  
                        INNER join cart on  cart.painting_id = paintings.id
                        left join colors on  colors.id = paintings.color_id
                        where cart.customer_id =  $customer_id
                        
            ";



        return DB::select($query);
    }

    public function emptyCart($customer_id){
        DB::table('cart')
        ->where('customer_id', $customer_id)
        ->delete();
    }
    
    public function cart_action($request ){
        if ($request->action =='add') {

            DB::table('cart')->insert(
                [
                'painting_id'    =>   $request->painting_id, 
                'customer_id'   =>   $request->customer_id,
                'customer_type' =>   $request->customer_type,
        
                ]
            );
            $query ="SELECT 
                        paintings.*,
                        colors.name as color,
                        images.file as logo
                        FROM paintings
                        LEFT JOIN images
                        ON paintings.id = images.imageable_id
                        AND images.field = 'logo' 
                        AND images.imageable_type LIKE '%paintings%'  
                        INNER join cart on  cart.painting_id = paintings.id
                        left join colors on  colors.id = paintings.color_id
                        where paintings.id =  $request->painting_id
                        
                ";
            return DB::select($query);
    
        }elseif ($request->action == 'delete') {
           

            $whereArray = array('painting_id' => $request->painting_id,
                                'customer_id' => $request->customer_id,
                                'customer_type' => $request->customer_type,
                            );

            $query = DB::table('cart');
            foreach($whereArray as $field => $value) {
                $query->where($field, $value);
            }
            return $query->delete();
           
        }

   
    }
    public function wishlist(){
        $customer_id = \Session::get('customer_id');
            $query ="   SELECT  paintings.*,
                        images.file as logo
                        FROM paintings
                        LEFT JOIN images
                        ON paintings.id = images.imageable_id
                        AND images.field = 'logo' 
                        AND images.imageable_type LIKE '%paintings%'   
                        INNER join wishlist on  wishlist.painting_id = paintings.id
                        and wishlist.customer_id =  $customer_id
                        
            ";



        return DB::select($query);
    }
    public function add_wishlist($request ){
        if ($request->action =='add') {

            DB::table('wishlist')->insert(
                [
                'painting_id'    =>   $request->painting_id, 
                'customer_id'   =>   $request->customer_id,
                'customer_type' =>   $request->customer_type,
        
                ]
            );
    
        }elseif ($request->action == 'delete') {
           

            $whereArray = array('painting_id' => $request->painting_id,
                                'customer_id' => $request->customer_id,
                                'customer_type' => $request->customer_type,
                            );

            $query = DB::table('wishlist');
            foreach($whereArray as $field => $value) {
                $query->where($field, $value);
            }
            return $query->delete();
           
        }

   
    }
}
