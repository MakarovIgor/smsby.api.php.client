<?php

namespace igormakarov\SmsByApiClient\Model;

class SmsStatus
{
    private int $sentUnixTime, $deliveredUnixTime;

    public function __construct(int $sentUnixTime, int $deliveredUnixTime)
    {
        $this->sentUnixTime = $sentUnixTime;
        $this->deliveredUnixTime = $deliveredUnixTime;
    }

    public function isSent(): bool
    {
        return $this->sentUnixTime > 0;
    }

    public function isDelivered(): bool
    {
        return $this->deliveredUnixTime > 0;
    }

    /**
     * @return int
     */
    public function getDeliveredUnixTime(): int
    {
        return $this->deliveredUnixTime;
    }

    /**
     * @return int
     */
    public function getSentUnixTime(): int
    {
        return $this->sentUnixTime;
    }
}