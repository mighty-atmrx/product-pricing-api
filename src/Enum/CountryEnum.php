<?php

namespace App\Enum;

use App\Exception\InvalidTaxNumberException;

enum CountryEnum: string
{
    case DE = 'DE';
    case IT = 'IT';
    case FR = 'FR';
    case GR = 'GR';

    public static function fromCode(string $code): self
    {
        $country = self::tryFrom($code);

        if (!$country) {
            throw new InvalidTaxNumberException();
        }

        return $country;
    }

    public function taxRate(): float
    {
        return match ($this) {
            self::DE => 0.19,
            self::IT => 0.22,
            self::FR => 0.20,
            self::GR => 0.24,
        };
    }
}
