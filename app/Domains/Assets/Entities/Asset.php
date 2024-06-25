<?php

namespace App\Domains\Assets\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $table = 'assets';
    protected $fillable = ['name','name_ar','description','description_ar', 'quantity', 'category_id', 'serial_number'];

    public function category()
    {
        return $this->belongsTo(\App\Domains\Assets\Entities\AssetCategory::class);
    }
    

    public function owners()
    {
        return $this->belongsToMany(\App\Models\User::class, 'asset_user')->withPivot('id','quantity');
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


