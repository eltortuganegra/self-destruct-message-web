<?php

namespace App\domain\Services\SecretDeleteService;

use App\domain\Services\ServiceRequest;
use App\domain\ValueObjects\ValueObjectsFactory;


class SecretDeleteServiceRequest implements ServiceRequest
{
    private $secretId;

    public function __construct(string $secretIdentifier)
    {
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $this->secretId = $secretIdFactory->create($secretIdentifier);
    }

    public function getSecretId()
    {
        return $this->secretId;
    }

}