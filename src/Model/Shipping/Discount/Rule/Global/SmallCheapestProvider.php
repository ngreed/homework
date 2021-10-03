<?php

declare(strict_types=1);

namespace App\Model\Shipping\Discount\Rule\Global;

use App\Model\Shipping\Discount\Rule\AbstractRule;
use App\Model\Shipping\Discount\Rule\RuleInterface;
use App\Model\Shipping\Transaction\TransactionInterface;
use App\Model\Shipping\Validator\PackageSize;

class SmallCheapestProvider extends AbstractRule implements RuleInterface, GlobalRuleInterface
{
    private array $providers = [];

    private float $lowestPrice = 999999999;

    /**
     * @inheritDoc
     *
     * checks if there is more than one provider with not equal small size shipping rates
     */
    public function shouldApplyGlobal(array $transactions): bool
    {
        $shouldApply = false;
        $isOneProviderAdded = false;

        foreach ($transactions as $transaction) {
            if ($transaction->getSize() !== PackageSize::SIZE_SMALL) {
                continue;
            }

            $provider = $transaction->getProvider();
            $providerCode = $provider->getCode();
            $providerPrice = $provider->getPrice(PackageSize::SIZE_SMALL);

            if (!in_array($providerCode, $this->providers)) {
                $this->providers[] = $providerCode;

                if ($providerPrice !== $this->lowestPrice) {
                    if ($isOneProviderAdded) {
                        $shouldApply = true;
                    }

                    $isOneProviderAdded = true;
                }

                if ($providerPrice < $this->lowestPrice) {
                    $this->lowestPrice = $providerPrice;
                }
            }
        }

        return $shouldApply;
    }

    protected function shouldApply(TransactionInterface $transaction): bool
    {
        if (($transaction->getSize() === PackageSize::SIZE_SMALL)
            && ($transaction->getPrice() !== $this->lowestPrice)
        ) {
            return true;
        }

        return false;
    }

    protected function getDiscountAmount(TransactionInterface $transaction): float
    {
        return $transaction->getPrice() - $this->lowestPrice;
    }
}