<?php

declare(strict_types=1);

namespace App\Tests;

use App\Enum\PaymentProcessorTypeEnum;
use App\Exception\PaymentProcessorNotFoundException;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\TestCase;
use App\Service\Payment\PaymentAdapterInterface;
use App\Service\Payment\PaymentProcessorResolver;

#[AllowMockObjectsWithoutExpectations]
class PaymentProcessorResolverTest extends TestCase
{
    public function testReturnsCorrectProcessor(): void
    {
        $paypal = $this->createMock(PaymentAdapterInterface::class);
        $stripe = $this->createMock(PaymentAdapterInterface::class);

        $paypal->method('supports')
            ->with(PaymentProcessorTypeEnum::PAYPAL)
            ->willReturn(true);

        $stripe->method('supports')
            ->with(PaymentProcessorTypeEnum::STRIPE)
            ->willReturn(false);

        $resolver = new PaymentProcessorResolver([$paypal, $stripe,]);

        $result = $resolver->getProcessor(PaymentProcessorTypeEnum::PAYPAL);

        $this->assertSame($paypal, $result);
    }

    public function testThrowsExceptionWhenProcessorNotFound(): void
    {
        $processor = $this->createMock(PaymentAdapterInterface::class);

        $processor->method('supports')
            ->willReturn(false);

        $resolver = new PaymentProcessorResolver([$processor]);

        $this->expectException(PaymentProcessorNotFoundException::class);

        $resolver->getProcessor(PaymentProcessorTypeEnum::STRIPE);
    }
}
