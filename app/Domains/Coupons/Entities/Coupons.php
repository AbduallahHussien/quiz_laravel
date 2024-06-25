<?php

namespace App\Domains\Coupons\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'discount',
        'expires_at',
    ];
    
}


