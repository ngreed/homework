<?php

declare(strict_types=1);

namespace App\Model\Shipping\Discount\Rule;

use App\Model\Shipping\Discount\Rule\Global\GlobalRuleInterface;

class RuleApplier implements RuleApplierInterface
{
    private const DISCOUNT_AMOUNT = 10; // realybej toks dalykas aisku butu saugomas duombazeje

    /**
     * @var GlobalRuleInterface[]
     */
    private array $globalRules;

    /**
     * @var RuleInterface[]
     */
    private array $rulesToApply;

    private DiscountResetInterface $discountResetRule;

    public function __construct(
        array $globalRules,
        array $rulesToApply,
        DiscountResetInterface $discountResetRule
    ) {
        $this->globalRules = $globalRules;
        $this->rulesToApply = $rulesToApply;
        $this->discountResetRule = $discountResetRule;
    }

    /**
     * @inheritDoc
     */
    public function apply(array $transactions): void
    {
        foreach ($this->globalRules as $globalRule) {
            if ($globalRule->shouldApplyGlobal($transactions)) {
                $this->rulesToApply[] = $globalRule;
            }
        }

        $discount = self::DISCOUNT_AMOUNT;

        foreach ($transactions as $transaction) {
            if ($this->discountResetRule->shouldReset($transaction)) {
                $discount = self::DISCOUNT_AMOUNT;
            }

            foreach ($this->rulesToApply as $rule) {
                if ($discount === 0) {
                    break;
                }

                $rule->apply($transaction, $discount);
            }
        }
    }
}