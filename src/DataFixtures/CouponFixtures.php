<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $coupons = [
            ['code' => 'D10', 'value' => '10', 'type' => 'percent', 'isActive' => true],
            ['code' => 'D5', 'value' => '10', 'type' => 'percent', 'isActive' => false],
            ['code' => 'D25', 'value' => '25', 'type' => 'fixed', 'isActive' => true],
            ['code' => 'D30', 'value' => '30', 'type' => 'fixed', 'isActive' => false],
        ];

        foreach ($coupons as $couponData) {
            $coupon = new Coupon();
            $coupon->setCode($couponData['code']);
            $coupon->setValue($couponData['value']);
            $coupon->setType($couponData['type']);
            $coupon->setIsActive($couponData['isActive']);
            $manager->persist($coupon);
        }

        $manager->flush();
    }
}
