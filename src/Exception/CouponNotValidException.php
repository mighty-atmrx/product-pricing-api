<?php

namespace App\Exception;

use Exception;

class CouponNotValidException extends Exception
{
    public function __construct()
    {
        parent::__construct('coupon_not_valid');
    }
}
