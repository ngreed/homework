<?php

declare(strict_types=1);

namespace App\Model\Shipping\Discount\Rule;

use App\Model\Shipping\Transaction\TransactionInterface;

class DiscountResetMonthly implements DiscountResetInterface
{
    private string $currentMonthDate = '';

    public function shouldReset(TransactionInterface $transaction): bool
    {
        $transactionMonthDate = $transaction->getDate()->format('mY');

        if ($this->currentMonthDate !== $transactionMonthDate) {
            $this->currentMonthDate = $transactionMonthDate;

            return true;
        }

        return false;
    }
}