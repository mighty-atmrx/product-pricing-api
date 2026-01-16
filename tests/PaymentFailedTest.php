<?php

namespace App\Tests;

use App\DTO\CalculatePriceDto;
use App\DTO\PriceInputDto;
use App\Enum\PaymentProcessorTypeEnum;
use App\Exception\PaymentFailedException;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use App\Service\Payment\PaymentAdapterInterface;
use App\Service\Payment\PaymentProcessorResolver;
use App\Service\PaymentService;
use App\Service\PriceCalculatorService;

#[AllowMockObjectsWithoutExpectations]
class PaymentFailedTest extends TestCase
{
    public function testPaymentFailed(): void
    {
        $this->expectException(PaymentFailedException::class);

        $logger = $this->createMock(LoggerInterface::class);
        $resolver = $this->createMock(PaymentProcessorResolver::class);
        $calculator = $this->createMock(PriceCalculatorService::class);
        $processor = $this->createMock(PaymentAdapterInterface::class);

        $calculator->method('calculate')
            ->willReturn(new CalculatePriceDto(
                basePrice: 100,
                discount: 10,
                tax: 10,
                finalPrice: 99,
            ));

        $resolver->method('getProcessor')
            ->with(PaymentProcessorTypeEnum::PAYPAL)
            ->willReturn($processor);

        $processor->method('pay')
            ->with(99.00)
            ->willThrowException(new PaymentFailedException());

        $service = new PaymentService($logger, $resolver, $calculator);

        $service->processPayment(
            PaymentProcessorTypeEnum::PAYPAL,
            new PriceInputDto(1, 'DE123456789', null)
        );
    }
}
