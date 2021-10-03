<?php

declare(strict_types=1);

namespace App\Model\Shipping\Transaction;

use App\Model\Shipping\Provider\ProviderRepositoryInterface;

class Decorator implements DecoratorInterface
{
    private const DATE_FORMAT = 'Y-m-d';

    private ProviderRepositoryInterface $providerRepository;

    public function __construct(ProviderRepositoryInterface $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    public function decorate(
        TransactionInterface $transaction,
        string $date,
        string $size,
        string $providerCode
    ): void {
        $provider = $this->providerRepository->get($providerCode);

        $transaction
            ->setDate(date_create_from_format(self::DATE_FORMAT, $date))
            ->setSize($size)
            ->setProvider($provider)
            ->setPrice($provider->getPrice($size))
            ->setIsValid(true);
    }
}
