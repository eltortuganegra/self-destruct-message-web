<?php

namespace App\domain\Services\SecretUnveilService;


use App\domain\Services\ServiceRequest;
use App\domain\ValueObjects\SecretId\SecretId;
use App\domain\ValueObjects\SecretId\SecretIdFactory;

class SecretUnveilServiceRequest implements ServiceRequest
{
    private $secretIdFactory;
    private $identifier;
    private $protocol;
    private $domain;

    public function __construct(SecretIdFactory $secretIdFactory)
    {
        $this->secretIdFactory = $secretIdFactory;
    }

    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function setProtocol(string $protocol)
    {
        $this->protocol = $protocol;
    }

    public function setDomain(string $domain)
    {
        $this->domain = $domain;
    }

    public function getSecretId(): SecretId
    {
        return $this->secretIdFactory->create($this->identifier);
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

}