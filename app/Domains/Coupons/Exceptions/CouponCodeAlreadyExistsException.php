<?php

namespace App\Domains\Coupons\Exceptions;

use Exception;

class CouponCodeAlreadyExistsException extends Exception
{
    protected $message = 'Coupon code already exists.';

}
