<?php

namespace App\Domains\Coupons\Exceptions;

use Exception;

class CouponNotFoundException extends Exception
{
    protected $message = "Coupon doesn't exist";

}
