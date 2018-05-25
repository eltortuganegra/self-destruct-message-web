<?php

namespace App\domain\Entities\Secret;


use App\domain\ValueObjects\Secret\SecretId;

class SecretFactoryImp implements SecretFactory
{
    static public function create(SecretId $secretId, string $message): Secret
    {
        return new SecretImp($secretId, $message);
    }
}