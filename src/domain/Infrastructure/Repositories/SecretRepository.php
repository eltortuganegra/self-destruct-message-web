<?php

namespace App\domain\Infrastructure\Repositories;

use App\domain\Entities\Secret\Secret;
use App\domain\ValueObjects\SecretId\SecretId;

interface SecretRepository
{
    public function add(Secret $secret);
    public function getBySecretId(SecretId $secretId);
}