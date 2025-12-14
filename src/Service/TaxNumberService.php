<?php

namespace App\Service;

use App\Exception\InvalidTaxNumberException;

class TaxNumberService
{
    private const array TAX_RATES = [
        'DE' => 0.19,
        'IT' => 0.22,
        'FR' => 0.20,
        'GR' => 0.24,
    ];

    public function getTaxRate(string $taxNumber): float
    {
        $countryCode = substr($taxNumber, 0, 2);

        if (!isset(self::TAX_RATES[$countryCode])) {
            throw new InvalidTaxNumberException();
        }

        return self::TAX_RATES[$countryCode];
    }
}
