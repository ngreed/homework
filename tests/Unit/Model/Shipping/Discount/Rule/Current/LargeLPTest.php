<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Shipping\Discount\Rule\Current;

use App\Model\Shipping\Discount\Rule\Current\LargeLP;
use App\Model\Shipping\Provider\LaPoste;
use App\Model\Shipping\Provider\MondialRelay;
use App\Tests\Unit\Model\Shipping\Discount\Rule\RuleTestUtilTrait;
use DateTime;
use PHPUnit\Framework\TestCase;

class LargeLPTest extends TestCase
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
        $rule = new LargeLP();

        for ($i = 0; $i < count($transactionData); $i++) {
            ${'transaction' . $i} = $this->buildTransaction($transactionData[$i]);

            $rule->apply(${'transaction' . $i}, $discountLimit);

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

        $date1 = new DateTime('2020-07-29');
        $date2 = new DateTime('2020-08-01');

        return [
            '3/4 same month valid' => [
                'discountLimit' => 20,
                'transactionData' => [
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 20),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 20),
                    $this->getTransactionDataForDataProvider(4.9, 'M', $providerLP, $date1, 0, 4.9, 20),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 6.9, 0, 13.1),
                ]
            ],
            '6/9 valid same month' => [
                'discountLimit' => 10,
                'transactionData' => [
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 10),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 10),
                    $this->getTransactionDataForDataProvider(4, 'L', $providerMR, $date1, 0, 4, 10),
                    $this->getTransactionDataForDataProvider(4, 'L', $providerMR, $date1, 0, 4, 10),
                    $this->getTransactionDataForDataProvider(4, 'L', $providerMR, $date1, 0, 4, 10),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 6.9, 0, 3.1),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 3.1),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 3.1),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 3.1),
                ]
            ],
            '6 valid in 2 months' => [
                'discountLimit' => 11,
                'transactionData' => [
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 11),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 11),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date2, 6.9, 0, 4.1),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date2, 0, 6.9, 4.1),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date2, 0, 6.9, 4.1),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date2, 0, 6.9, 4.1),
                ]
            ],
            '3 valid, no discount left' => [
                'discountLimit' => 0,
                'transactionData' => [
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 0),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 0),
                    $this->getTransactionDataForDataProvider(6.9, 'L', $providerLP, $date1, 0, 6.9, 0),
                ]
            ],
        ];
    }
}
