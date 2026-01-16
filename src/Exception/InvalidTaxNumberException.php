<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidTaxNumberException extends ApiException
{
    public function getErrorMessage(): string
    {
        return 'Tax number not valid';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
