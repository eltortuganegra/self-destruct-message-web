<?php

namespace App\domain\Entities\Secret;


use App\domain\ValueObjects\SecretId\SecretId;

interface SecretFactory
{
    public function create(SecretId $secretId, string $message): Secret;
}