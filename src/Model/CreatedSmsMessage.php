<?php

namespace igormakarov\SmsByApiClient\Model;

class CreatedSmsMessage
{
    private int $parts;
    private int $length;
    private int $messageId;
    private string $alphaName;
    private int $time;

    public function __construct($parts, $length, $messageId, $alphaName, $time)
    {
        $this->parts = $parts;
        $this->length = $length;
        $this->messageId = $messageId;
        $this->alphaName = $alphaName;
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function getParts(): int
    {
        return $this->parts;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * @return string
     */
    public function getAlphaName(): string
    {
        return $this->alphaName;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }
}