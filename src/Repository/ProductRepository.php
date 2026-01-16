<?php

namespace App\Repository;

use App\Entity\Product;
use App\Exception\ProductNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getById(int $productId): Product
    {
        $product = $this->findOneBy(['id' => $productId]);
        if (!$product) {
            throw new ProductNotFoundException();
        }

        return $product;
    }
}
