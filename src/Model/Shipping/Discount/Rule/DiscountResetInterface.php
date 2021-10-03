<?php

namespace App\Model\Shipping\Discount\Rule;

use App\Model\Shipping\Transaction\TransactionInterface;

interface DiscountResetInterface
{
    public function shouldReset(TransactionInterface $transaction): bool;
}