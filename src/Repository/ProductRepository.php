<?php

namespace App\Repository;

use App\Entity\Product;
use App\Exception\ProductNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getPriceById(int $id): string
    {
        $product = $this->findOneBy(['id' => $id]);
        if (!$product) {
            throw new ProductNotFoundException();
        }

        return $product->getPrice();
    }
}
