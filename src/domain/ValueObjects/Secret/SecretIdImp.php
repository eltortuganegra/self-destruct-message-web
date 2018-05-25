<?php

namespace App\domain\ValueObjects\Secret;


class SecretIdImp implements SecretId
{

    private $identifier;

    private function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    static public function create(string $identifier): SecretId
    {
        return new static($identifier);
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}