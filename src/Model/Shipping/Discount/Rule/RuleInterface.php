<?php

namespace App\Model\Shipping\Discount\Rule;

use App\Model\Shipping\Transaction\TransactionInterface;

interface RuleInterface
{
    public function apply(TransactionInterface $transaction, float &$remainingDiscount): void;
}