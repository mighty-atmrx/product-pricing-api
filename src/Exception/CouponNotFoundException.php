<?php

namespace App\Exception;

use Exception;

class CouponNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('coupon_not_found');
    }
}
