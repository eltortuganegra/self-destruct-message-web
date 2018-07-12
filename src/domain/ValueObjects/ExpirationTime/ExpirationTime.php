<?php

namespace App\domain\ValueObjects\ExpirationTime;


interface ExpirationTime
{
    public function getSeconds(): int;
}