<?php

namespace App\Domains\Slides\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slides extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'sub_title',
        'button_text',
        'button_link',
        'title_ar',
        'sub_title_ar',
        'button_text_ar',
    ];
    public function images()
    {
        return $this->morphMany(\App\Domains\Images\Entities\Image::class, 'imageable', 'imageable_type', 'imageable_id');
    }
    
}


