<?php

namespace App\domain\ValueObjects\SecretId;


class SecretIdImp implements SecretId
{

    private $identifier;

    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}