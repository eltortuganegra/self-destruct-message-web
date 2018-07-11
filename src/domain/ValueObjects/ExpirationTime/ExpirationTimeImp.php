<?php

namespace App\domain\ValueObjects\ExpirationTime;


use DateTime;

class ExpirationTimeImp implements ExpirationTime
{
    private $date;

    public function __construct()
    {
        $this->date = new DateTime();
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }
}