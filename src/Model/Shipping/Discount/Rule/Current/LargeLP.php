<?php

declare(strict_types=1);

namespace App\Model\Shipping\Discount\Rule\Current;

use App\Model\Shipping\Discount\Rule\AbstractRule;
use App\Model\Shipping\Discount\Rule\RuleInterface;
use App\Model\Shipping\Transaction\TransactionInterface;
use App\Model\Shipping\Validator\PackageSize;

class LargeLP extends AbstractRule implements RuleInterface
{
    private const EVERY_NTH = 3; // jei sita reiksme galetu buti keiciama, tai turbut butu laikoma duombazeje.

    private const PROVIDER_CODE = 'LP';

    private int $count = 0;

    private array $monthsApplied = [];

    protected function shouldApply(TransactionInterface $transaction): bool
    {
        if (($transaction->getProvider()->getCode() === self::PROVIDER_CODE)
            && ($transaction->getSize() === PackageSize::SIZE_LARGE)
            && (!in_array($this->getFormattedDate($transaction), $this->monthsApplied)) // priklausomai nuo duomenu statistikos, efektyvumo sumetimais situos tikrinimus galima sukeisti vietomis
        ) {
            $this->count++;

            if ($this->count === self::EVERY_NTH) {
                $this->monthsApplied[] = $this->getFormattedDate($transaction);
                $this->count = 0;

                return true;
            }
        }

        return false;
    }

    protected function getDiscountAmount(TransactionInterface $transaction): float
    {
        return $transaction->getPrice();
    }

    private function getFormattedDate(TransactionInterface $transaction): string
    {
        return $transaction->getDate()->format('mY'); // toki keista formata pasirinkautodel, kad kai tikrins, ar toks menesis jau yra toks pridetas, tai pirma ziuretu menesi ir tik po to metus
    }
}
