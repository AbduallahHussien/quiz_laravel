<?php

namespace App\Domains\Addons\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table = 'addons_items';
    protected $fillable = ['name','name_ar','slug','addon_id','location_id','description','description_ar','price','price_euro','quantity','barcode','barcode_secondary'];
    public function images()
    {
        return $this->morphMany(\App\Domains\Images\Entities\Image::class, 'imageable', 'imageable_type', 'imageable_id');
    }
    
}


