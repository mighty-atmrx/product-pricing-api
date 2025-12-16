<?php

namespace App\Interface;

interface ProductRepositoryInterface
{
    public function getPriceById(int $productId): float;
}
