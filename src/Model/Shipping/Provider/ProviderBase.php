<?php

declare(strict_types=1);

namespace App\Model\Shipping\Provider;

class ProviderBase
{
    protected string $code;

    protected array $priceMap;

    public function getCode(): string
    {
        return $this->code;
    }

    public function getPrice(string $size): float
    {
        return $this->priceMap[$size];
    }
}