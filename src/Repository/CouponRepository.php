<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Coupon;
use App\Exception\CouponNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use mysql_xdevapi\Exception;

/**
 * @extends ServiceEntityRepository<Coupon>
 */
class CouponRepository extends ServiceEntityRepository implements CouponRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    public function getByCodeActive(string $code): Coupon
    {
        $coupon = $this->findOneBy(['code' => $code, 'isActive' => true]);

        if (!$coupon) {
            throw new CouponNotFoundException();
        }

        return $coupon;
    }
}
