<?php

namespace igormakarov\SmsByApiClient\Model;

class SmsStatus
{
    public const STATUS_SENT = 'SENT';
    public const STATUS_DELIVERED = 'DELIVERED';
    public const STATUS_UNDELIVERED = 'UNDELIVERED';
    public const STATUS_NEW = 'NEW';

    private int $sentUnixTime, $deliveredUnixTime;
    private string $status;

    public function __construct(int $sentUnixTime, int $deliveredUnixTime, string $status)
    {
        $this->sentUnixTime = $sentUnixTime;
        $this->deliveredUnixTime = $deliveredUnixTime;
        $this->status = $status;
    }

    public function isSent(): bool
    {
        return $this->status == self::STATUS_SENT;
    }

    public function isDelivered(): bool
    {
        return $this->deliveredUnixTime > 0 && $this->status == self::STATUS_DELIVERED;
    }

    public function isUndelivered(): bool
    {
        return $this->status === self::STATUS_UNDELIVERED;
    }

    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }

    public function isTimeOut(): bool
    {
        if ($this->deliveredUnixTime > 0) {
            return false;
        }

        return time() >= strtotime('+2 day', $this->getSentUnixTime());
    }

    public function getDeliveredUnixTime(): int
    {
        return $this->deliveredUnixTime;
    }

    public function getSentUnixTime(): int
    {
        return $this->sentUnixTime;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}