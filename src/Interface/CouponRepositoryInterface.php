<?php

declare(strict_types=1);

namespace App\Interface;

use App\Entity\Coupon;

interface CouponRepositoryInterface
{
    public function getByCode(string $code): Coupon;
}
