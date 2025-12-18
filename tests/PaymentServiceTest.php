<?php

declare(strict_types=1);

namespace App\Tests;

use App\DTO\CalculatePriceDto;
use App\DTO\CalculatePriceInputDto;
use App\Enum\PaymentProcessorType;
use App\Service\Payment\PaymentAdapterInterface;
use App\Service\Payment\PaymentProcessorResolver;
use PHPUnit\Framework\TestCase;
use App\Service\PaymentService;
use App\Service\PriceCalculatorService;
use Psr\Log\NullLogger;

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
            ->with(PaymentProcessorType::PAYPAL)
            ->willReturn($processor);

        $processor->expects($this->once())
            ->method('pay')
            ->with(99.00);

        $service = new PaymentService(
            logger: $logger,
            resolver: $resolver,
            priceCalculatorService: $calculator
        );

        $dto = new CalculatePriceInputDto(
            productId: 1,
            taxNumber: 'DE123456789',
            couponCode: null
        );

        $service->payment(PaymentProcessorType::PAYPAL, $dto);
        $this->assertTrue(true);
    }
}
