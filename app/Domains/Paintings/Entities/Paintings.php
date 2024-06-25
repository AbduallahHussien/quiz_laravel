<?php

namespace App\Domains\Paintings\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paintings extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'name_ar',
        'slug',
        'description',
        'description_ar',
        'category_id',
        'theme_id',
        'style_id',
        'color_id',
        'location_id',
        'price',
        'price_euro',
        'barcode',
        'barcode_secondary',
        'artist_id',
        'column',
        'row',
        'unique',
        'signed',
        'framed',
        'status',
        'is_featured',
        'is_popular',
        'vendor_id',
        'length',
        'width',
        'hight',
        'acquisition_certificate',
        'painting_back',
    ];
    public function images()
    {
        return $this->morphMany(\App\Domains\Images\Entities\Image::class, 'imageable', 'imageable_type', 'imageable_id');
    }

    /**
     * Get the artist that own this painting
     */
    public function artist()
    {
        return $this->belongsTo("App\Domains\Artists\Entities\Artists");
    }
    

    /**
     * Get the location that this painting is on it
     */
    public function location()
    {
        return $this->belongsTo("App\Domains\Locations\Entities\Locations");
    }
    
}


