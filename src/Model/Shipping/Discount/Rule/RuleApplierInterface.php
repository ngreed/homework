<?php

declare(strict_types=1);

namespace App\Model\Shipping\Discount\Rule;

use App\Model\Shipping\Transaction\TransactionInterface;

interface RuleApplierInterface
{
    /**
     * @param TransactionInterface[] $transactions
     */
    public function apply(array $transactions): void;
}