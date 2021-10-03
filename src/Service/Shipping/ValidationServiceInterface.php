<?php

namespace App\Service\Shipping;

interface ValidationServiceInterface
{
    public function isValid(
        string $date,
        string $packageSize,
        string $carrierCode
    ): bool;
}