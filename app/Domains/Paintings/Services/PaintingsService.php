<?php

namespace App\Domains\Paintings\Services;

use App\Domains\Paintings\Interfaces\PaintingsRepositoryInterface;
use App\Domains\Paintings\Exceptions\PaintingNotFoundException;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Auth;

Class PaintingsService{

    private $paintings_respository;
    private $image_repository;

    public function __construct(PaintingsRepositoryInterface $paintings_respository,
    ImageRepositoryInterface $image_repository)
	{
        $this->paintings_respository = $paintings_respository;
        $this->image_repository = $image_repository;
       
	}
    public function generateUniqueSlug($id,$name, $table, $column ) {
        $slug = Str::slug($name);
        $count = 1;
        $originalSlug = $slug;
        if($id){
            if (DB::table($table)->where($column, $slug)->where('id', $id)->exists()) {
                return $slug;   
            }else{
                while (DB::table($table)->where($column, $slug)->exists()) {
                    $slug = $originalSlug . '-' . Str::random(5); // Add a random 5-character string
                    $count++;
                }
            }
        }else{
                 while (DB::table($table)->where($column, $slug)->exists()) {
                            $slug = $originalSlug . '-' . Str::random(5); // Add a random 5-character string
                            $count++;
                        }
        }
        
        
        return $slug;
        
    }

    /**
     * Get Paintings.
     *
     * @param  string  $flag
     * @param  int  $num
     * @return \Illuminate\Http\Response
     */
    public function getPaintings($flag, $limit)
    {
       return  $this->paintings_respository->getPaintings($flag, $limit);
    }


    public function create($request){

        $data_model = $this->request_to_data_model($request);
        $slug = $this->generateUniqueSlug('',$request->slug,'paintings','slug');
        $data_model['slug'] = $slug;
        if($data_model['status'] == null){
            $data_model['status'] = 'available';
        }
        $vendor = Auth::guard('vendor');
        if($vendor){
            $data_model['vendor_id'] = $vendor->id();
        }

        if ($request->acquisition_certificate) {
            $data_model['acquisition_certificate'] = $this->image_repository->imageUpload($request->acquisition_certificate);
        } 
        
        if ($request->painting_back) {
            $data_model['painting_back'] = $this->image_repository->imageUpload($request->painting_back);
        }

        $paintings = $this->paintings_respository->create($data_model);
        if ($request->image) {
            $this->image_repository->upload($request->image, $paintings, "logo","logo");
        }
        
        return $paintings;

    }
    
   
    public function update($id,$request){
        $data_model = $this->request_to_data_model($request);
        $slug = $this->generateUniqueSlug($id,$request->slug,'paintings','slug');
        $data_model['slug'] = $slug;
        if($data_model['status'] == null){
            $data_model['status'] = $this->findPaintingStatus($id);
        }

        if ($request->acquisition_certificate) {
            $data_model['acquisition_certificate'] = $this->image_repository->imageUpload($request->acquisition_certificate);
        } 
        
        if ($request->painting_back) {
            $data_model['painting_back'] = $this->image_repository->imageUpload($request->painting_back);
        }

        $paintings = $this->paintings_respository->update($id,$data_model);
        
        if ($request->image) {
            $this->image_repository->update_field($paintings , "logo","logo",$request->image);
        }
      

        return $paintings;
    }


    public function findPaintingStatus($id){
        $is_sold =  $this->paintings_respository->isPaintingSold($id);
        return $is_sold? 'sold':'available';
    }

    public function findPaintingBySlug($slug){
        return $this->paintings_respository->findPaintingBySlug($slug); 
    }

    public function PaintingByCategoryId($id,$perPage,$search,$sort_by){
        return $this->paintings_respository->PaintingByCategoryId($id,$perPage,$search,$sort_by);
    }
    public function TopRated($limit){
        return $this->paintings_respository->TopRated($limit); 
    }
    
    
    public function upload_image_gallery($request){
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
               $id =  DB::table('images')->insertGetId(
                    [
                    'file' => $imageName,
                    'imageable_id' =>$request->id,
                    'imageable_type'=>'App\Domains\Paintings\Entities\Paintings',
                    'field'=>'gallery',
                    'caption'=>'gallery',
                    'created_at'=> date('Y-m-d')
                    ]
                );
               

            return  $id;
        }
    }
    public function cart()
    {
        return $this->paintings_respository->cart();
    }
    
    public function emptyCart()
    {
        $customer_id = \Session::get('customer_id');
        return $this->paintings_respository->emptyCart($customer_id);
    }
    
    public function cart_action($request)
    {
        return $this->paintings_respository->cart_action($request);
    }

    public function add_wishlist($request)
    {
        return $this->paintings_respository->add_wishlist($request);

    }
    public function wishlist()
    {
        return $this->paintings_respository->wishlist();

    }
    
   
    
    public function PaintingByArtistId($id,$limit){
        return $this->paintings_respository->PaintingByArtistId($id,$limit);
    }

    public function makePaintingAs($request){
        return $this->paintings_respository->makePaintingAs($request);
    }
    
    public function remove_image_gallery($request){
        return $this->paintings_respository->remove_image_gallery($request);
    }

    public function get_instance(){
        return $this->paintings_respository->get_instance();
    }

    public function prepare_data_table($vendor_id =  null){
        return $this->paintings_respository->prepare_data_table($vendor_id);
    }

    public function all(){
        return $this->paintings_respository->all();
    }

    public function find($id){
        return $this->paintings_respository->find($id);
    }

    public function delete($id){
        $this->paintings_respository->delete($id);
    }

    private function request_to_data_model($request){
       
            return [
                "name" => $request->name,
                "name_ar" => $request->name_ar,
                "slug" => $request->slug,
                "category_id"=>$request->category_id,
                "artist_id"=>$request->artist_id,
                "theme_id"=>$request->theme_id,
                "style_id"=>$request->style_id,
                "color_id"=>$request->color_id,
                "location_id"=>$request->location_id,
                "description" => $request->description,
                "description_ar" => $request->description_ar,
                'price' => $request->price,
                'price_euro'  => $request->price_euro,
                'barcode' => $request->barcode,
                'barcode_secondary' => $request->barcode_secondary,
                'row' => $request->row,
                'column' => $request->column,
                'unique' => $request->has('unique') ? true : false,
                'signed' => $request->has('signed') ? true : false,
                'framed' => $request->has('framed') ? true : false,
                'is_featured' => $request->has('is_featured') ? true : false,
                'is_popular' => $request->has('is_popular') ? true : false,
                'status' => $request->has('unavailable') ? 'unavailable' : null,
                'length' => $request->length,
                'width' => $request->width,
                'hight' => $request->hight,
            ];
      

    }

    public function entity_to_data_model($entity){
        return (object) [
            "id" => $entity->id,
            "name" => $entity->name,
            "name_ar" => $entity->name_ar,
            "slug" => $entity->slug,
            "category_id"=>$entity->category_id,
            "artist_id"=>$entity->artist_id,
            "artist_category_id"=>$entity->artist?->category_id,
            "theme_id"=>$entity->theme_id,
            "style_id"=>$entity->style_id,
            "color_id"=>$entity->color_id,
            "location_id"=>$entity->location_id,
            "location"=>$entity->location,
            'price' => $entity->price,
            'price_euro'  => $entity->price_euro,
            'barcode' => $entity->barcode,
            'barcode_secondary' => $entity->barcode_secondary,
            "description" => $entity->description,
            "description_ar" => $entity->description_ar,
            'row' => $entity->row,
            'column' => $entity->column,
            "image" => $entity->images->where('field','logo')->first(),
            "gallery" => $entity->images->where('field','gallery'),
            'framed' => $entity->framed,
            'is_featured' => $entity->is_featured,
            'is_popular' => $entity->is_popular,
            'unique' => $entity->unique,
            'signed' => $entity->signed,
            'status' => $entity->status,
            'length' => $entity->length,
            'width' => $entity->width,
            'hight' => $entity->hight,
            'acquisition_certificate' => $entity->acquisition_certificate,
            'painting_back' => $entity->painting_back,
        ];
    }


    public function findPaintingsByNameOrBarcode($term){
        return $this->paintings_respository->findPaintingsByNameOrBarcode($term);
    }

    public function getPaintingsData($ids){
        $paintings = [];
        foreach ($ids as $id) {
            $painting = $this->paintings_respository->findAvailablePainting($id);
            if(!$painting){
                throw new PaintingNotFoundException("Painting doesn't exist");
            }
            $paintings[] = $painting;
        }
        return $paintings;
        
    }
   
}
