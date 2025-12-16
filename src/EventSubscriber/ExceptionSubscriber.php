<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exception\CouponNotFoundException;
use App\Exception\CouponNotValidException;
use App\Exception\InvalidTaxNumberException;
use App\Exception\PaymentFailedException;
use App\Exception\PaymentProcessorNotFoundException;
use App\Exception\ProductNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        match (true) {
            $e instanceof ProductNotFoundException =>
            $this->json($event, 'product_not_found', Response::HTTP_NOT_FOUND),

            $e instanceof CouponNotValidException =>
            $this->json($event, 'coupon_not_valid', Response::HTTP_BAD_REQUEST),

            $e instanceof InvalidTaxNumberException =>
            $this->json($event, 'invalid_tax_number', Response::HTTP_BAD_REQUEST),

            $e instanceof PaymentProcessorNotFoundException =>
            $this->json($event, 'payment_processor_not_found', Response::HTTP_BAD_REQUEST),

            $e instanceof PaymentFailedException =>
            $this->json($event, 'payment_failed', Response::HTTP_BAD_REQUEST),

            $e instanceof CouponNotFoundException =>
            $this->json($event, 'coupon_not_found', Response::HTTP_NOT_FOUND),

            default => $this->json($event, 'internal_error', Response::HTTP_INTERNAL_SERVER_ERROR)
        };
    }

    private function json(ExceptionEvent $event, string $message, int $status): void
    {
        $event->setResponse(
            new JsonResponse(['error' => $message], $status)
        );
    }
}
