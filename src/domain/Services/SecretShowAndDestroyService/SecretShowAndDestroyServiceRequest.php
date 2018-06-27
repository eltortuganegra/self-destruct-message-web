<?php

namespace App\domain\Services\SecretShowAndDestroyService;


use App\domain\Services\ServiceRequest;
use App\domain\ValueObjects\SecretId\SecretId;
use App\domain\ValueObjects\SecretId\SecretIdFactory;

class SecretShowAndDestroyServiceRequest implements ServiceRequest
{
    private $secretIdFactory;
    private $identifier;

    public function __construct(SecretIdFactory $secretIdFactory)
    {
        $this->secretIdFactory = $secretIdFactory;
    }

    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function getSecretId(): SecretId
    {
        return $this->secretIdFactory->create($this->identifier);
    }

}