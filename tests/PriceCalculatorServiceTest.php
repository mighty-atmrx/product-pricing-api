<?php

namespace App\Tests;

use App\DTO\CalculatePriceInputDto;
use App\Entity\Coupon;
use App\Enum\CouponTypeEnum;
use App\Interface\CouponRepositoryInterface;
use App\Interface\ProductRepositoryInterface;
use App\Service\PriceCalculatorService;
use App\Service\TaxNumberService;
use PHPUnit\Framework\TestCase;

class PriceCalculatorServiceTest extends TestCase
{
    public function testCalculateWithoutCoupon(): void
    {
        $productRepo = $this->createStub(ProductRepositoryInterface::class);
        $couponRepo  = $this->createStub(CouponRepositoryInterface::class);
        $taxService  = $this->createStub(TaxNumberService::class);

        $productRepo->method('getPriceById')->willReturn(100.00);
        $taxService->method('getTaxRate')->willReturn(0.20);

        $service = new PriceCalculatorService($productRepo, $couponRepo, $taxService);

        $result = $service->calculate(new CalculatePriceInputDto(1, 'DE123456789', null));

        $this->assertSame(100.00, $result->getBasePrice());
        $this->assertSame(0.0, $result->getDiscount());
        $this->assertSame(20.00, $result->getTax());
        $this->assertSame(120.00, $result->getFinalPrice());
    }

    public function testCalculateWithCoupon(): void
    {
        $productRepo = $this->createStub(ProductRepositoryInterface::class);
        $couponRepo = $this->createStub(CouponRepositoryInterface::class);
        $taxService = $this->createStub(TaxNumberService::class);

        $coupon = new Coupon();
        $coupon->setIsActive(true);
        $coupon->setType(CouponTypeEnum::PERCENT->value);
        $coupon->setValue(10);

        $productRepo->method('getPriceById')->willReturn(100.00);
        $couponRepo->method('getByCode')->willReturn($coupon);
        $taxService->method('getTaxRate')->willReturn(0.20);

        $service = new PriceCalculatorService(
            $productRepo,
            $couponRepo,
            $taxService
        );

        $result = $service->calculate(
            new CalculatePriceInputDto(1, 'DE123456789', 'PROMO10')
        );

        $this->assertSame(100.00, $result->getBasePrice());
        $this->assertSame(10.00, $result->getDiscount());
        $this->assertSame(18.00, $result->getTax());
        $this->assertSame(108.00, $result->getFinalPrice());
    }
}
