<?php

declare(strict_types=1);

namespace App\Service\Shipping;

use App\Model\Shipping\Discount\Rule\RuleApplierInterface;
use App\Model\Shipping\Transaction\DecoratorInterface;
use App\Model\Shipping\Transaction\Transaction;
use App\Model\Shipping\Transaction\TransactionInterface;
use Exception;

class ParseFromFileService implements ParseFromFileServiceInterface
{
    private ValidationServiceInterface $validationService;

    private RuleApplierInterface $ruleApplier;

    private DecoratorInterface $transactionDecorator;

    public function __construct(
        ValidationServiceInterface $validationService,
        RuleApplierInterface $ruleApplier,
        DecoratorInterface $transactionDecorator
    ) {
        $this->validationService = $validationService;
        $this->ruleApplier = $ruleApplier;
        $this->transactionDecorator = $transactionDecorator;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function parse(string $filepath): array
    {
        $handle = fopen($filepath, "r");
        if ($handle) {
            $transactions = [];
            $invalidTransactions = [];

            while (($line = fgets($handle)) !== false) {
                $line = trim(preg_replace('~[\r\n]+~', '', $line));
                $values = explode(' ', $line);

                $transaction = new Transaction();
                $transaction->setDataString($line);

                $transactions[]= $transaction;

                try {
                    $date = $values[0];
                    $size = $values[1];
                    $providerCode = $values[2];

                    if (!$this->validationService->isValid($date, $size, $providerCode)) {
                        $transaction->setIsValid(false);
                        $invalidTransactions[] = array_pop($transactions);

                        continue;
                    }

                    $this->transactionDecorator->decorate(
                        $transaction,
                        $date,
                        $size,
                        $providerCode
                    );
                } catch (Exception $e) {
                    // TODO log exception
                    $transaction->setIsValid(false);
                    $invalidTransactions[] = array_pop($transactions);
                }
            }

            fclose($handle);
        } else {
            throw new Exception('Error opening input file.');
        }

        $this->ruleApplier->apply($transactions);
        $transactions = array_merge($transactions, $invalidTransactions);

        return $this->sortTransactions($transactions);
    }

    /**
     * @param TransactionInterface[] $transactions
     * @return TransactionInterface[]
     */
    private function sortTransactions(array $transactions): array
    {
        usort(
            $transactions,
            function(TransactionInterface $a, TransactionInterface $b) {
                return $a->getId() - $b->getId();
            }
        );

        return $transactions;
    }
}