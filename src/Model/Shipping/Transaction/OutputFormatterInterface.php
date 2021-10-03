<?php

namespace App\Model\Shipping\Transaction;

interface OutputFormatterInterface
{
    public function format(TransactionInterface $transaction): string;
}
