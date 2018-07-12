<?php

namespace App\domain\Entities\Secret;


use App\domain\ValueObjects\ExpirationTime\ExpirationTime;
use App\domain\ValueObjects\Message\Message;
use App\domain\ValueObjects\SecretId\SecretId;
use DateTime;


interface SecretFactory
{
    public function create(
        SecretId $secretId,
        Message $message,
        ExpirationTime $expirationTime
    ): Secret;

    public function createFromRepository(
        SecretId $secretId,
        Message $message,
        ExpirationTime $expirationTime,
        DateTime $expirationDate
    );
}