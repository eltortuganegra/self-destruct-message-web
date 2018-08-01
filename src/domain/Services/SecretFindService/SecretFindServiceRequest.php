<?php

namespace App\domain\Services\SecretFindService;


use App\domain\Services\ServiceRequest;
use App\domain\ValueObjects\ValueObjectsFactory;

class SecretFindServiceRequest implements ServiceRequest
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