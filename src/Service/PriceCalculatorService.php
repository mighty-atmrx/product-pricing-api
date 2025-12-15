<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\CouponTypeEnum;
use App\Exception\CouponNotValidException;
use App\Exception\InvalidTaxNumberException;
use App\Exception\ProductNotFoundException;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;

readonly class PriceCalculatorService
{
    public function __construct(
        private ProductRepository $productRepository,
        private CouponRepository $couponRepository,
        private TaxNumberService $taxNumberService,
    ){
    }

    /**
     * @throws ProductNotFoundException
     * @throws CouponNotValidException
     * @throws InvalidTaxNumberException
     */
    public function calculate(array $data): float
    {
        $price = (float) $this->productRepository->getPriceById($data['product']);

        if (!empty($data['couponCode'])) {
            $coupon = $this->couponRepository->getTypeByCode($data['couponCode']);
            if (!$coupon) {
                throw new CouponNotValidException();
            }

            if ($coupon['type'] === CouponTypeEnum::FIXED) {
                $price = $this->applyFixedCoupon($price, $coupon['value']);
            } elseif ($coupon['type'] === CouponTypeEnum::PERCENT) {
                $price = $this->applyPercentCoupon($price, $coupon['value']);
            }
        }

        $taxRate = $this->taxNumberService->getTaxRate($data['taxNumber']);
        return round($this->applyTax($price, $taxRate), 2);
    }

    private function applyFixedCoupon(float $basePrice, float $couponValue): float
    {
        return max(0, $basePrice - $couponValue);
    }

    private function applyPercentCoupon(float $basePrice, float $couponValue): float
    {
        return max(0, $basePrice - ($basePrice * $couponValue / 100));
    }

    private function applyTax(float $priceAfterDiscount, float $taxRate): float
    {
        return $priceAfterDiscount + ($priceAfterDiscount * $taxRate);
    }
}
