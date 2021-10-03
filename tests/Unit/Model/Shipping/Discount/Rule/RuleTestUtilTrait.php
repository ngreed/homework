<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Shipping\Discount\Rule;

use App\Model\Shipping\Provider\ProviderInterface;
use App\Model\Shipping\Transaction\Transaction;
use App\Model\Shipping\Transaction\TransactionInterface;
use DateTime;

trait RuleTestUtilTrait
{
    protected function getTransactionDataForDataProvider(
        float $price,
        string $size,
        ProviderInterface $provider,
        DateTime $date,
        float $expectedDiscount,
        float $expectedPrice,
        float $expectedDiscountLeft
    ): array {
        return [
            'price' => $price,
            'size' => $size,
            'provider' => $provider,
            'date' => $date,
            'expectedDiscount' => $expectedDiscount,
            'expectedPrice' => $expectedPrice,
            'expectedDiscountLeft' => $expectedDiscountLeft
        ];
    }

    protected function buildTransaction(array $data): TransactionInterface
    {
        $transaction = new Transaction();
        $transaction
            ->setPrice($data['price'])
            ->setSize($data['size'])
            ->setProvider($data['provider'])
            ->setDate($data['date']);

        return $transaction;
    }
}
