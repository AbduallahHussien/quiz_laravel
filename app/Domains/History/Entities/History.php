<?php

namespace App\Domains\History\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';
    use HasFactory;
    protected $fillable = ['action', 'model', 'model_id', 'description', 'user_id'];
}
