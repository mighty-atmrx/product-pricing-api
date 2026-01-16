<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class CouponNotValidException extends ApiException
{
    public function getErrorMessage(): string
    {
        return 'Coupon not valid';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
