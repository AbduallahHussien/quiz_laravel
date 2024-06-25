<?php

namespace App\Domains\Courses\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory  extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description','name_ar','description_ar'];
    public function images()
    {
        return $this->morphMany(\App\Domains\Images\Entities\Image::class, 'imageable', 'imageable_type', 'imageable_id');
    }

    public function courses()
    {
        return $this->hasMany(\App\Domains\Courses\Entities\Course::class);
    }
    
}


