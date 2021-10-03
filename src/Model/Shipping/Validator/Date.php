<?php

declare(strict_types=1);

namespace App\Model\Shipping\Validator;

use DateTime;

class Date implements ValidatorInterface
{
    public function isValid(string $input): bool
    {
        return date_create_from_format('Y-m-d', $input) instanceof DateTime;
    }
}