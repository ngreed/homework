<?php

namespace App\Model\Shipping\Provider;

interface ProviderRepositoryInterface
{
    public function get(string $code): ProviderInterface;

    /**
     * @return ProviderInterface[]
     */
    public function getAll(): array;
}