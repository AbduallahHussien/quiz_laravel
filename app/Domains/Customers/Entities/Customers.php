<?php

namespace App\Domains\Customers\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $fillable = ['full_name','email','phone','gender','birth_date','country_id','area','password','serial_number'];
 
    public function images()
    {
        return $this->morphMany(\App\Domains\Images\Entities\Image::class, 'imageable', 'imageable_type', 'imageable_id');
    }

    public function save(array $options = [])
    {
        // Generate a new serial number if it's not already set
        if (!$this->serial_number) {
            $this->serial_number = $this->generateSerialNumber();
        }

        return parent::save($options);
    }

    protected function generateSerialNumber()
    {
        return str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
    }
}


