<?php

namespace App\domain\ValueObjects\ExpirationTime;


use DateTime;

interface ExpirationTime
{
    public function getDate(): DateTime;
}