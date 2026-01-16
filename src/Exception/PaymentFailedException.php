<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class PaymentFailedException extends ApiException
{
    public function getErrorMessage(): string
    {
        return 'Payment failed';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }
}
