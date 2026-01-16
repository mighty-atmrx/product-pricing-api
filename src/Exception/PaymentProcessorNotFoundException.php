<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class PaymentProcessorNotFoundException extends ApiException
{
    public function getErrorMessage(): string
    {
        return 'Payment processor not found';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
