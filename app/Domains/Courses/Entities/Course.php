<?php

namespace App\Domains\Courses\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = ['title','title_ar', 'description','description_ar', 'category_id'];
    public function images()
    {
        return $this->morphMany(\App\Domains\Images\Entities\Image::class, 'imageable', 'imageable_type', 'imageable_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Domains\Courses\Entities\CourseCategory::class);
    }
    
}


