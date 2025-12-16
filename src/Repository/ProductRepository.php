<?php

namespace App\Repository;

use App\Entity\Product;
use App\Exception\ProductNotFoundException;
use App\Interface\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getPriceById(int $productId): float
    {
        $product = $this->findOneBy(['id' => $productId]);
        if (!$product) {
            throw new ProductNotFoundException();
        }

        return $product->getPrice();
    }
}
