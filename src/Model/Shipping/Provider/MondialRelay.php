<?php

declare(strict_types=1);

namespace App\Model\Shipping\Provider;

use App\Model\Shipping\Validator\PackageSize;

class MondialRelay extends ProviderBase implements ProviderInterface
{
    protected string $code = 'MR';

    protected array $priceMap = [
        PackageSize::SIZE_SMALL => 2,
        PackageSize::SIZE_MEDIUM => 3,
        PackageSize::SIZE_LARGE => 4
    ];
}