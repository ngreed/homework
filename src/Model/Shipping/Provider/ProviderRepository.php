<?php

declare(strict_types=1);

namespace App\Model\Shipping\Provider;

class ProviderRepository implements ProviderRepositoryInterface
{
    private array $providers;

    /**
     * @param ProviderInterface[] $providers
     */
    public function __construct(array $providers)
    {
        foreach ($providers as $provider) {
            $this->providers[$provider->getCode()] = $provider;
        }
    }

    public function get(string $code): ProviderInterface
    {
        return $this->providers[$code];
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->providers;
    }
}