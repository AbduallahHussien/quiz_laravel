<?php

namespace App\Domains\Locations\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationAddonItem extends Model
{
    protected $table = 'locations_addons_items';
    protected $fillable = ['location_id','addons_item_id','quantity'];
}