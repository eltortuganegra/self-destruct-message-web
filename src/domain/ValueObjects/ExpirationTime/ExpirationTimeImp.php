<?php

namespace App\domain\ValueObjects\ExpirationTime;


use DateTime;

class ExpirationTimeImp implements ExpirationTime
{
    private $dateTime;

    public function __construct(DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function getDate(): DateTime
    {
        return $this->dateTime;
    }
}