<?php

declare(strict_types=1);

namespace App\Service\Shipping;

use App\Model\Shipping\Validator\ValidatorInterface;

class ValidationService implements ValidationServiceInterface
{
    private ValidatorInterface $dateValidator;

    private ValidatorInterface $packageSizeValidator;

    private ValidatorInterface $carrierCodeValidator;

    public function __construct(
        ValidatorInterface $dateValidator,
        ValidatorInterface $packageSizeValidator,
        ValidatorInterface $carrierCodeValidator
    ) {
        $this->dateValidator = $dateValidator;
        $this->packageSizeValidator = $packageSizeValidator;
        $this->carrierCodeValidator = $carrierCodeValidator;
    }

    public function isValid(
        string $date,
        string $packageSize,
        string $carrierCode
    ): bool {
        if ($this->dateValidator->isValid($date)
            && $this->packageSizeValidator->isValid($packageSize)
            && $this->carrierCodeValidator->isValid($carrierCode)
        ) {
            return true;
        }

        return false;
    }
}