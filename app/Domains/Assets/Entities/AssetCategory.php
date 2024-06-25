<?php

namespace App\Domains\Assets\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetCategory  extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'name_ar', 'description_ar'];

    public function Assets()
    {
        return $this->hasMany(\App\Domains\Assets\Entities\Asset::class);
    }
    
}


