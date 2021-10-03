<?php

declare(strict_types=1);

namespace App\Model\Shipping\Transaction;

use App\Model\Shipping\Provider\ProviderInterface;
use DateTime;

class Transaction implements TransactionInterface
{
    private static int $newestId = 0; // pridejau tik del eiliskumo islaikymo. paprastai ORM'as sita automatiskai suhandlintu

    private int $id;

    private string $dataString;

    private DateTime $date;

    private string $size;

    private ProviderInterface $provider;

    private float $price;

    private float $discount = 0;

    private bool $isValid;

    public function __construct()
    {
        $this::$newestId++;
        $this->id = $this::$newestId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDataString(): string
    {
        return $this->dataString;
    }

    public function setDataString(string $dataString): Transaction
    {
        $this->dataString = $dataString;

        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): Transaction
    {
        $this->date = $date;

        return $this;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size): Transaction
    {
        $this->size = $size;

        return $this;
    }

    public function getProvider(): ProviderInterface
    {
        return $this->provider;
    }

    public function setProvider(ProviderInterface $provider): Transaction
    {
        $this->provider = $provider;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): Transaction
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): Transaction
    {
        $this->discount = $discount;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): Transaction
    {
        $this->isValid = $isValid;

        return $this;
    }
}
