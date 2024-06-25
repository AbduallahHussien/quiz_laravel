<?php

namespace App\Domains\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'country_id',
        'area',
        'status',
        'password',
        'serial_number',
        'national_id_front',
        'national_id_back',
        'status_card_front',
        'status_card_back',
        'iban_letter',
        'national_address',
    ];
 
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


