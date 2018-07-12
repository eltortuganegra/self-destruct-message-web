<?php

namespace App\domain\ValueObjects\ExpirationTime;


use DateTime;

class ExpirationTimeImp implements ExpirationTime
{
    private $seconds;

    public function __construct(int $seconds)
    {
        assert($seconds > 0, '$seconds must be greater than zero.');
        $this->seconds = $seconds;
    }

    public function getSeconds(): int
    {
        return $this->seconds;
    }


}