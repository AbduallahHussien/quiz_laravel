<?php

namespace App\Domains\Categories\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = ['name','name_ar','slug','parent_id','description','description_ar' ,'type'];
    public function images()
    {
        return $this->morphMany(\App\Domains\Images\Entities\Image::class, 'imageable', 'imageable_type', 'imageable_id');
    }
    
}


