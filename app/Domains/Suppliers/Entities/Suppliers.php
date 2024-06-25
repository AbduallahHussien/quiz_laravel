<?php

namespace App\Domains\Suppliers\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'country_id',
        'area',
    ];
 
    public function images()
    {
        return $this->morphMany(\App\Domains\Images\Entities\Image::class, 'imageable', 'imageable_type', 'imageable_id');
    }
}


