<?php

declare(strict_types=1);

namespace App\Tests;

use App\Enum\PaymentProcessorType;
use App\Exception\PaymentProcessorNotFoundException;
use App\Interface\PaymentProcessorInterface;
use App\Payment\PaymentProcessorResolver;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\TestCase;

#[AllowMockObjectsWithoutExpectations]
class PaymentProcessorResolverTest extends TestCase
{
    public function testReturnsCorrectProcessor(): void
    {
        $paypal = $this->createMock(PaymentProcessorInterface::class);
        $stripe = $this->createMock(PaymentProcessorInterface::class);

        $paypal->method('supports')
            ->with(PaymentProcessorType::PAYPAL)
            ->willReturn(true);

        $stripe->method('supports')
            ->with(PaymentProcessorType::STRIPE)
            ->willReturn(false);

        $resolver = new PaymentProcessorResolver([$paypal, $stripe,]);

        $result = $resolver->getProcessor(PaymentProcessorType::PAYPAL);

        $this->assertSame($paypal, $result);
    }

    public function testThrowsExceptionWhenProcessorNotFound(): void
    {
        $processor = $this->createMock(PaymentProcessorInterface::class);

        $processor->method('supports')
            ->willReturn(false);

        $resolver = new PaymentProcessorResolver([$processor]);

        $this->expectException(PaymentProcessorNotFoundException::class);

        $resolver->getProcessor(PaymentProcessorType::STRIPE);
    }
}
