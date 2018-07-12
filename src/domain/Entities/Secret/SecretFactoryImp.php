<?php

namespace App\domain\Entities\Secret;


use App\domain\ValueObjects\ExpirationTime\ExpirationTime;
use App\domain\ValueObjects\Message\Message;
use App\domain\ValueObjects\SecretId\SecretId;

class SecretFactoryImp implements SecretFactory
{
    public function create(SecretId $secretId, Message $message, ExpirationTime $expirationTime): Secret
    {
        return new SecretImp($secretId, $message, $expirationTime);
    }
}