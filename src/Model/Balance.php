<?php

namespace igormakarov\SmsByApiClient\Model;

class Balance
{
    private float $balanceAmount;
    private string $currency;

    public function __construct($balanceAmount, $currency)
    {
        $this->balanceAmount = $balanceAmount;
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->balanceAmount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}