<?php

namespace App\domain\Entities\Secret;


use App\domain\ValueObjects\Secret\SecretId;

interface SecretFactory
{
    static public function create(SecretId $secretId, string $message): Secret;
}