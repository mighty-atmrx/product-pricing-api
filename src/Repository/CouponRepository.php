<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Coupon;
use App\Exception\CouponNotFoundException;
use App\Interface\CouponRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coupon>
 */
class CouponRepository extends ServiceEntityRepository implements CouponRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    public function getByCode(string $code): Coupon
    {
        $coupon = $this->findOneBy(['code' => $code]);

        if (!$coupon) {
            throw new CouponNotFoundException();
        }

        return $coupon;
    }
}
