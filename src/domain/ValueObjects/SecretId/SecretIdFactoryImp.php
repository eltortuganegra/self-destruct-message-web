<?php

namespace App\domain\ValueObjects\SecretId;


class SecretIdFactoryImp implements SecretIdFactory
{
    public function create(string $identifier): SecretId
    {
        return new SecretIdImp($identifier);
    }
}