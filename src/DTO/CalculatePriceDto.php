<?php

namespace App\DTO;

readonly class CalculatePriceDto implements \JsonSerializable
{
    public function __construct(
        private float $basePrice,
        private float $discount,
        private float $tax,
        private float $finalPrice,
        private string $currency = 'EUR'
    ){
    }

    public function jsonSerialize(): array
    {
        return [
            'basePrice' => $this->basePrice,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'finalPrice' => $this->finalPrice,
            'currency' => $this->currency
        ];
    }
}
