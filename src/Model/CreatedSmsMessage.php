<?php

namespace igormakarov\SmsByApiClient\Model;

class CreatedSmsMessage
{
    private int $parts;
    private int $length;
    private int $id;
    private string $alphaName;
    private int $time;

    public function __construct($parts, $length, $id, $alphaName, $time)
    {
        $this->parts = $parts;
        $this->length = $length;
        $this->id = $id;
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
    public function getId(): int
    {
        return $this->id;
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