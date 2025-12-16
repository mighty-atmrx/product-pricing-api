<?php

namespace App\Interface;

use App\Entity\Coupon;

interface CouponRepositoryInterface
{
    public function getByCode(string $code): Coupon;
}
