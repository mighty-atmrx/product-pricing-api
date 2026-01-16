<?php

declare(strict_types=1);

namespace App\Tests;

use App\DTO\CalculatePriceDto;
use App\DTO\PriceInputDto;
use App\Enum\PaymentProcessorTypeEnum;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use App\Service\Payment\PaymentAdapterInterface;
use App\Service\Payment\PaymentProcessorResolver;
use App\Service\PaymentService;
use App\Service\PriceCalculatorService;

class PaymentServiceTest extends TestCase
{
    public function testPaymentSuccess(): void
    {
        $logger = new NullLogger();
        $resolver = $this->createMock(PaymentProcessorResolver::class);
        $calculator = $this->createMock(PriceCalculatorService::class);
        $processor = $this->createMock(PaymentAdapterInterface::class);

        $calculator->expects($this->once())
            ->method('calculate')
            ->willReturn(new CalculatePriceDto(
                basePrice: 100,
                discount: 10,
                tax: 10,
                finalPrice: 99,
            ));

        $resolver->expects($this->once())
            ->method('getProcessor')
            ->with(PaymentProcessorTypeEnum::PAYPAL)
            ->willReturn($processor);

        $processor->expects($this->once())
            ->method('pay')
            ->with(99.00);

        $service = new PaymentService(
            logger: $logger,
            resolver: $resolver,
            priceCalculatorService: $calculator
        );

        $dto = new PriceInputDto(
            productId: 1,
            taxNumber: 'DE123456789',
            couponCode: null
        );

        $service->processPayment(PaymentProcessorTypeEnum::PAYPAL, $dto);
        $this->assertTrue(true);
    }
}
