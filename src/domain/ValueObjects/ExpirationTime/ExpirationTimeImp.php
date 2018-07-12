<?php

namespace App\domain\ValueObjects\ExpirationTime;


use DateTime;

class ExpirationTimeImp implements ExpirationTime
{
    private $seconds;

    public function __construct(int $seconds)
    {
        $this->seconds = $seconds;
    }

    public function getSeconds(): int
    {
        return $this->seconds;
    }

}