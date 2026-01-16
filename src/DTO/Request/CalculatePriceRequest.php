<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\DTO\PriceRequestDto;
use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceRequest
{
    public function __construct(
        #[Assert\Valid] public PriceRequestDto $price
    ){
    }
}
