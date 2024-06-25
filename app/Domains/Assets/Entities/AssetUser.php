<?php

namespace App\Domains\Assets\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetUser extends Model
{
    use HasFactory;
    protected $table = 'asset_user';
    protected $fillable = ['asset_id', 'user_id', 'quantity'];

}


