<?php

namespace App\domain\ValueObjects\ExpirationTime;


use DateTime;

interface ExpirationTimeFactory
{
    public function create(DateTime $dateTime): ExpirationTime;
}