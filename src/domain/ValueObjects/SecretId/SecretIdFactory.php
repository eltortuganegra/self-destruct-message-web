<?php

namespace App\domain\ValueObjects\SecretId;


interface SecretIdFactory
{
    public function create(string $identifier): SecretId;
}