<?php

namespace App\DTO;

use App\Enum\CurrencyEnum;

readonly class CalculatePriceDto implements \JsonSerializable
{
    public function __construct(
        private float $basePrice,
        private float $discount,
        private float $tax,
        private float $finalPrice,
        private CurrencyEnum $currency = CurrencyEnum::EUR
    ){
    }

    public function jsonSerialize(): array
    {
        return [
            'basePrice' => $this->basePrice,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'finalPrice' => $this->finalPrice,
            'currency' => $this->currency->value
        ];
    }

    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function getTax(): float
    {
        return $this->tax;
    }

    public function getFinalPrice(): float
    {
        return $this->finalPrice;
    }
}
