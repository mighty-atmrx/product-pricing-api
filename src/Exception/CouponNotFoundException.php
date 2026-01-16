<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class CouponNotFoundException extends ApiException
{
    public function getErrorMessage(): string
    {
        return 'Product not found';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
