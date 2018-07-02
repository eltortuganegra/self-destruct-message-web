<?php

namespace App\domain\Infrastructure\Repositories;

use App\domain\Entities\Secret\Secret;
use App\domain\ValueObjects\SecretId\SecretId;

class MemorySecretRepository implements SecretRepository
{

    private $secrets = [];

    public function add(Secret $secret): void
    {
        $identifier = $secret->getSecretId()->getIdentifier();
        $this->secrets[$identifier] = $secret;
    }

    public function getBySecretId(SecretId $secretId): ?Secret
    {
        $identifier = $secretId->getIdentifier();

        return $this->secrets[$identifier];
    }

    public function remove(Secret $secret): void
    {
        $identifier = $secret->getSecretId()->getIdentifier();

        unset($this->secrets[$identifier]);
    }
}