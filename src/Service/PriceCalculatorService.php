<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CalculatePriceDto;
use App\DTO\CalculatePriceInputDto;
use App\Enum\CouponTypeEnum;
use App\Enum\CurrencyEnum;
use App\Repository\CouponRepositoryInterface;
use App\Repository\ProductRepositoryInterface;

readonly class PriceCalculatorService
{
    private const int PERCENT_DIVISOR = 100;

    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CouponRepositoryInterface $couponRepository,
        private TaxNumberService $taxNumberService,
    ){
    }

    public function calculate(CalculatePriceInputDto $dto): CalculatePriceDto
    {
        $basePrice = round($this->productRepository->getPriceById($dto->productId), 2);

        $discount  = 0;
        if (!empty($dto->couponCode)) {
            $coupon = $this->couponRepository->getByCodeActive($dto->couponCode);
            if ($coupon->isActive()) {
                if ($coupon->getType() === CouponTypeEnum::FIXED->value) {
                    $discount = $coupon->getValue();
                } elseif ($coupon->getType() === CouponTypeEnum::PERCENT->value) {
                    $discount = $this->getPercentDiscount($basePrice, $coupon->getValue());
                }
            }
        }

        $priceDiscount = max(0, round($basePrice - $discount, 2));

        $taxRate = $this->taxNumberService->getTaxRate($dto->taxNumber);
        $tax = $this->calculateTax($priceDiscount, $taxRate);
        $finalPrice = round($priceDiscount + $tax, 2);
        return new CalculatePriceDto($basePrice, $discount, $tax, $finalPrice, CurrencyEnum::EUR);
    }

    private function getPercentDiscount(float $basePrice, float $couponValue): float
    {
        return ($basePrice * $couponValue) / self::PERCENT_DIVISOR;
    }

    private function calculateTax(float $price, float $taxRate): float
    {
        return round($price * $taxRate, 2);
    }
}
