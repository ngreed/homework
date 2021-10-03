<?php

namespace App\Model\Shipping\Transaction;

use App\Model\Shipping\Provider\ProviderInterface;
use DateTime;

interface TransactionInterface
{
    public function getId(): int;

    public function setDataString(string $dataString): Transaction;

    public function getDate(): DateTime;

    public function setDate(DateTime $date): Transaction;

    public function getSize(): string;

    public function setSize(string $size): Transaction;

    public function getProvider(): ProviderInterface;

    public function setProvider(ProviderInterface $provider): Transaction;

    public function getPrice(): float;

    public function setPrice(float $price): Transaction;

    public function getDiscount(): float;

    public function setDiscount(float $discount): Transaction;

    public function isValid(): bool;

    public function setIsValid(bool $isValid): Transaction;
}