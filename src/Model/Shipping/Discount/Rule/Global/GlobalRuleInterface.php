<?php

namespace App\Model\Shipping\Discount\Rule\Global;

use App\Model\Shipping\Transaction\TransactionInterface;

interface GlobalRuleInterface
{
    /**
     * @param TransactionInterface[] $transactions
     */
    public function shouldApplyGlobal(array $transactions): bool;
}