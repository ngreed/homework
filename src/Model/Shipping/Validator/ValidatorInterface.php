<?php

declare(strict_types=1);

namespace App\Model\Shipping\Validator;

interface ValidatorInterface
{
    public function isValid(string $input): bool;
}