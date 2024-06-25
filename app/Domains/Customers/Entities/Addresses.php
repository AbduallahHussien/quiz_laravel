<?php

namespace App\Domains\Customers\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;
    protected $fillable = [
        "first_name",
        "last_name",
        "company_name",
        "address_line1",
        "address_line2",
        "email",
        "phone",
        "country_id",
        "customer_id",
        "city",
        "state",
        "is_default",
        "postal_code"
    ];
 
}


