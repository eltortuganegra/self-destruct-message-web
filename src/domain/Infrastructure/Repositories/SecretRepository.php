<?php

namespace App\domain\Infrastructure\Repositories;

use App\domain\Entities\Secret\Secret;
use App\domain\ValueObjects\SecretId\SecretId;

interface SecretRepository
{
    public function add(Secret $secret): void;
    public function remove(Secret $secret): void;
    public function getBySecretId(SecretId $secretId): ?Secret;
    public function nextIdentity(): SecretId;
}