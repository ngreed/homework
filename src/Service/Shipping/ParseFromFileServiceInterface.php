<?php

declare(strict_types=1);

namespace App\Service\Shipping;

use App\Model\Shipping\Transaction\TransactionInterface;

interface ParseFromFileServiceInterface
{
    /**
     * @return TransactionInterface[]
     */
    public function parse(string $filepath): array;
}