<?php

namespace App\Model\Shipping\Provider;

interface ProviderInterface
{
    public function getCode(): string;

    public function getPrice(string $size): float;
}