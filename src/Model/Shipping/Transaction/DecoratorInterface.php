<?php

namespace App\Model\Shipping\Transaction;

interface DecoratorInterface
{
    public function decorate(
        TransactionInterface $transaction,
        string $date,
        string $size,
        string $providerCode
    ): void;
}
