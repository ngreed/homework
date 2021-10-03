<?php

declare(strict_types=1);

namespace App\Model\Shipping\Transaction;

class OutputFormatter implements OutputFormatterInterface
{
    public function format(TransactionInterface $transaction): string
    {
        if ($transaction->isValid()) {
            $discount = $transaction->getDiscount();

            $output = sprintf(
                "%s %s %s %s %s\r\n",
                $transaction->getDate()->format('Y-m-d'),
                $transaction->getSize(),
                $transaction->getProvider()->getCode(),
                number_format($transaction->getPrice(), 2),
                $discount ? number_format($discount, 2) : '-'
            );
        } else {
            $output = sprintf(
                "%s %s\r\n",
                $transaction->getDataString(),
                'Ignored'
            );
        }

        return $output;
    }
}
