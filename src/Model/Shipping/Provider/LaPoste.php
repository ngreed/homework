<?php

declare(strict_types=1);

namespace App\Model\Shipping\Provider;

use App\Model\Shipping\Validator\PackageSize;

class LaPoste extends ProviderBase implements ProviderInterface
{
    protected string $code = 'LP';

    protected array $priceMap = [
        PackageSize::SIZE_SMALL => 1.5,
        PackageSize::SIZE_MEDIUM => 4.9,
        PackageSize::SIZE_LARGE => 6.9
    ];
}