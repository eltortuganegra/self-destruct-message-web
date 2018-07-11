<?php

namespace App\domain\ValueObjects\ExpirationTime;


use DateTime;

class StubExpirationTimeImp extends ExpirationTimeImp
{
    public function getDate(): DateTime
    {
        $theSecretOfMonkeyIslandReleaseDate = new DateTime('1990-10-15');

        return $theSecretOfMonkeyIslandReleaseDate;
    }

}