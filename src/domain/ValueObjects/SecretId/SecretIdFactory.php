<?php

namespace App\domain\ValueObjects\SecretId;


class SecretIdFactory
{
    public function create(string $identifier): SecretId
    {
        return new SecretIdImp($identifier);
    }
}