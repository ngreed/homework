<?php

declare(strict_types=1);

namespace App\Model\Shipping\Validator;

use App\Model\Shipping\Provider\ProviderInterface;
use App\Model\Shipping\Provider\ProviderRepositoryInterface;

class CarrierCode implements ValidatorInterface
{
    private array $codes;

    public function __construct(ProviderRepositoryInterface $providerRepository)
    {
        foreach ($providerRepository->getAll() as $provider) {
            $this->codes[] = $provider->getCode();
        }
    }

    public function isValid(string $input): bool
    {
        return in_array($input, $this->codes);
    }
}