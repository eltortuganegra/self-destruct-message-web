<?php

namespace App\domain\ValueObjects\Secret;


interface SecretId
{
    static public function create(string $identifier): SecretId;
    public function getIdentifier(): string;
}