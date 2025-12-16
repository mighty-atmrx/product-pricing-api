<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class CalculatePriceInputDto
{
    public function __construct(
        public int $productId,
        public string $taxNumber,
        public ?string $couponCode = null,
    ) {
    }
}
