<?php

declare(strict_types=1);

namespace App\Model\Shipping\Discount\Rule;

use App\Model\Shipping\Transaction\TransactionInterface;

abstract class AbstractRule
{
    public function apply(TransactionInterface $transaction, float &$remainingDiscount): void
    {
        if (!$this->shouldApply($transaction)) {
            return;
        }

        $price = $transaction->getPrice();
        $discount = $this->getDiscountAmount($transaction);
        $discount = $discount < $remainingDiscount ? $discount : $remainingDiscount;

        if ($price >= $discount) {
            $transaction->setPrice($price - $discount);
            $transaction->setDiscount($discount);
        } else {
            $transaction->setPrice(0);
            $transaction->setDiscount($price);
        }

        $remainingDiscount -= $discount;
    }

    abstract protected function shouldApply(TransactionInterface $transaction): bool;

    abstract protected function getDiscountAmount(TransactionInterface $transaction): float;
}