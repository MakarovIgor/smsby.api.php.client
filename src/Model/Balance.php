<?php

namespace igormakarov\SmsByApiClient\Model;

class Balance
{
    private float $balanceAmount, $viberBalanceAmount;
    private string $currency;

    public function __construct($balanceAmount, $viberBalanceAmount, $currency)
    {
        $this->balanceAmount = $balanceAmount;
        $this->viberBalanceAmount = $viberBalanceAmount;
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
     * @return float
     */
    public function getViberAmount(): float
    {
        return $this->viberBalanceAmount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}