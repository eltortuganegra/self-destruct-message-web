<?php

namespace App\domain\ValueObjects\ExpirationTime;


use DateTime;

class ExpirationTimeFactoryImp implements ExpirationTimeFactory
{

    public function create(DateTime $dateTime): ExpirationTime
    {
        return new ExpirationTimeImp($dateTime);
    }
}