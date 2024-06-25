<?php

namespace App\Domains\Images\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imageable_type', 'imageable_id', 'file','caption','field', 'created_by', 'updated_by'
    ];


    /**
     * Get the parent imageable model (page or ... ).
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}