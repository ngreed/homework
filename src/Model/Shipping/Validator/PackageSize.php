<?php

declare(strict_types=1);

namespace App\Model\Shipping\Validator;

class PackageSize implements ValidatorInterface
{
    public const SIZE_SMALL = 'S';
    public const SIZE_MEDIUM = 'M';
    public const SIZE_LARGE = 'L';

    private array $sizes = [self::SIZE_SMALL, self::SIZE_MEDIUM, self::SIZE_LARGE]; // paprastai turbut butu paimama is duombazes

    public function isValid(string $input): bool
    {
        return in_array($input, $this->sizes);
    }
}