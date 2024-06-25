<?php

namespace App\Domains\Styles\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Styles extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','description','name_ar','description_ar'];
    public function images()
    {
        return $this->morphMany(\App\Domains\Images\Entities\Image::class, 'imageable', 'imageable_type', 'imageable_id');
    }
    
}


