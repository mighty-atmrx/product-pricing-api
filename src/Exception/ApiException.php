<?php

namespace App\Exception;

use RuntimeException;

abstract class ApiException extends RuntimeException
{
    public function getErrorMessage(): string
    {
        return 'Internal server error. Please try again later.';
    }

    public function getStatusCode(): int
    {
        return 500;
    }
}
