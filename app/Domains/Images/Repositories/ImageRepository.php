<?php

namespace App\Domains\Images\Repositories;

use App\Domains\Images\Entities\Image;
use App\Domains\Images\Interfaces\ImageRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;


class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{

    /**
    * CompanyRepository constructor.
    *
    * @param Image $model
    */
    public function __construct(Image $model)
    {
        parent::__construct($model);
    }

    /**
     * Update and upload news's image.
     *
     * @param File $file
     * @return void
     */
    public function upload($file, $upload_to_model, $field = null, $caption = null)
    {

        $image_name = time() . rand() . '.' . $file->getClientOriginalExtension();
        // Upload image
        $file->move(public_path('images'), $image_name);

        $upload_to_model->images()
            ->create(['file' => $image_name,'field' => $field, 'caption' => $caption]);
    }

    public function update_field($upload_to_model, $field, $caption, $file = null){
        $image = $upload_to_model->images()->where('field', $field)->first();
        if($image){
            if($file){
                $image_name = time() . rand() . '.' . $file->getClientOriginalExtension();
                // Upload image
                $file->move(public_path('images'), $image_name);
                if (file_exists(public_path() . '/images/' . $image->file)) {
                    unlink(public_path() . '/images/' . $image->file);
                }
                $image->file = $image_name;
            }
            if($caption){
                $image->caption = $caption;
            }
            $image->save();
        }else{
            if($file){
                $image_name = time() . rand() . '.' . $file->getClientOriginalExtension();
                // Upload image
                $file->move(public_path('images'), $image_name);
                $upload_to_model->images()
                    ->create(['file' => $image_name,'field' => $field, 'caption' => $caption]);
            }
        }


    }   
    
    public function imageUpload($file){

        if($file){
            $image_name = time() . rand() . '.' . $file->getClientOriginalExtension();
            // Upload image
            $file->move(public_path('images'), $image_name);
            return $image_name;
        }
        return null;
    }

}
