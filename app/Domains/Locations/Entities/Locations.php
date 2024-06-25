<?php

namespace App\Domains\Locations\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;
    protected $fillable = ['name','name_ar','country_id','city_id' ,'area', 'address','address_ar','columns','rows'];
    public function images()
    {
        return $this->morphMany(\App\Domains\Images\Entities\Image::class, 'imageable', 'imageable_type', 'imageable_id');
    }


    public function items()
    {
        return $this->belongsToMany(
            \App\Domains\Addons\Entities\Items::class,
            'locations_addons_items',
            'location_id',
            'addons_item_id'
            )->withPivot('quantity');
    }
    
}


