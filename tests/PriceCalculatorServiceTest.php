<?php

namespace App\Tests;

use App\DTO\PriceInputDto;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Enum\CouponTypeEnum;
use App\Repository\CouponRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;
use App\Service\PriceCalculatorService;
use App\Service\TaxNumberService;

class PriceCalculatorServiceTest extends TestCase
{
    public function testCalculateWithoutCoupon(): void
    {
        $productRepo = $this->createStub(ProductRepositoryInterface::class);
        $couponRepo  = $this->createStub(CouponRepositoryInterface::class);
        $taxService  = $this->createStub(TaxNumberService::class);

        $product = new Product();
        $product->setPrice(100.00);

        $productRepo->method('getById')->willReturn($product);
        $taxService->method('getTaxRate')->willReturn(0.20);

        $service = new PriceCalculatorService($productRepo, $couponRepo, $taxService);

        $result = $service->calculate(new PriceInputDto(1, 'DE123456789', null));

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
        $coupon->setType(CouponTypeEnum::PERCENT);
        $coupon->setValue(10);

        $product = new Product();
        $product->setPrice(100.00);

        $productRepo->method('getById')->willReturn($product);
        $couponRepo->method('getByCodeActive')->willReturn($coupon);
        $taxService->method('getTaxRate')->willReturn(0.20);

        $service = new PriceCalculatorService(
            $productRepo,
            $couponRepo,
            $taxService
        );

        $result = $service->calculate(
            new PriceInputDto(1, 'DE123456789', 'PROMO10')
        );

        $this->assertSame(100.00, $result->getBasePrice());
        $this->assertSame(10.00, $result->getDiscount());
        $this->assertSame(18.00, $result->getTax());
        $this->assertSame(108.00, $result->getFinalPrice());
    }
}
