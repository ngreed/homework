<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Shipping\Discount\Rule\Global;

use App\Model\Shipping\Discount\Rule\Global\SmallCheapestProvider;
use App\Model\Shipping\Provider\LaPoste;
use App\Model\Shipping\Provider\MondialRelay;
use App\Tests\Unit\Model\Shipping\Discount\Rule\RuleTestUtilTrait;
use DateTime;
use PHPUnit\Framework\TestCase;

class SmallCheapestProviderTest extends TestCase
{
    use RuleTestUtilTrait;

    /**
     * @test
     * @dataProvider applyDataProvider
     */
    public function apply(
        float $discountLimit,
        array $transactionData,
    ): void {
        $rule = new SmallCheapestProvider();
        $transactions = [];

        for ($i = 0; $i < count($transactionData); $i++) {
            ${'transaction' . $i} = $this->buildTransaction($transactionData[$i]);
            $transactions[] = ${'transaction' . $i};
        }

        $rule->shouldApplyGlobal($transactions);

        for ($i = 0; $i < count($transactions); $i++) {
            $rule->apply($transactions[$i], $discountLimit);

            $this->assertEquals($transactionData[$i]['expectedDiscount'], ${'transaction' . $i}->getDiscount());
            $this->assertEquals($transactionData[$i]['expectedPrice'], ${'transaction' . $i}->getPrice());
            $this->assertEquals($transactionData[$i]['expectedDiscountLeft'], $discountLimit);
        }
    }

    public function applyDataProvider(): array
    {
        // TODO cia reiketu naudoti mock'us, taciau laiko taupymo sumetimais to nepadariau
        $providerLP = new LaPoste();
        $providerMR = new MondialRelay();

        $date = new DateTime('2021-07-22');

        return [
            '5/9 applied, not enough discount' => [
                'discountLimit' => 2,
                'transactionData' => [
                    $this->getTransactionDataForDataProvider(2, 'S', $providerMR, $date, 0.5, 1.5, 1.5),
                    $this->getTransactionDataForDataProvider(1.5, 'S', $providerLP, $date, 0, 1.5, 1.5),
                    $this->getTransactionDataForDataProvider(2, 'S', $providerMR, $date, 0.5, 1.5, 1),
                    $this->getTransactionDataForDataProvider(4.9, 'M', $providerLP, $date, 0, 4.9, 1),
                    $this->getTransactionDataForDataProvider(2, 'S', $providerMR, $date, 0.5, 1.5, 0.5),
                    $this->getTransactionDataForDataProvider(2, 'S', $providerMR, $date, 0.5, 1.5, 0),
                    $this->getTransactionDataForDataProvider(5.5, 'L', $providerMR, $date, 0, 5.5, 0),
                    $this->getTransactionDataForDataProvider(1.5, 'S', $providerLP, $date, 0, 1.5, 0),
                    $this->getTransactionDataForDataProvider(2, 'S', $providerMR, $date, 0, 2, 0),
                ]
            ],
            '0/5' => [
                'discountLimit' => 8,
                'transactionData' => [
                    $this->getTransactionDataForDataProvider(1.5, 'S', $providerLP, $date, 0, 1.5, 8),
                    $this->getTransactionDataForDataProvider(3, 'M', $providerLP, $date, 0, 3, 8),
                    $this->getTransactionDataForDataProvider(5.5, 'L', $providerMR, $date, 0, 5.5, 8),
                    $this->getTransactionDataForDataProvider(6, 'L', $providerLP, $date, 0, 6, 8),
                    $this->getTransactionDataForDataProvider(1.5, 'S', $providerLP, $date, 0, 1.5, 8),
                ]
            ],
            '4/6' => [
                'discountLimit' => 1.5,
                'transactionData' => [
                    $this->getTransactionDataForDataProvider(2, 'S', $providerMR, $date, 0.5, 1.5, 1),
                    $this->getTransactionDataForDataProvider(2, 'S', $providerMR, $date, 0.5, 1.5, 0.5),
                    $this->getTransactionDataForDataProvider(1.5, 'S', $providerLP, $date, 0, 1.5, 0.5),
                    $this->getTransactionDataForDataProvider(3, 'M', $providerLP, $date, 0, 3, 0.5),
                    $this->getTransactionDataForDataProvider(2, 'S', $providerMR, $date, 0.5, 1.5, 0),
                    $this->getTransactionDataForDataProvider(2, 'S', $providerMR, $date, 0, 2, 0),
                ]
            ],
        ];
    }
}