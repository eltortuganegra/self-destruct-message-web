<?php

namespace App\domain\Entities\Secret;


use App\domain\ValueObjects\SecretId\SecretId;

class SecretFactoryImp implements SecretFactory
{
    public function create(SecretId $secretId, string $message): Secret
    {
        return new SecretImp($secretId, $message);
    }
}