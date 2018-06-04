<?php

namespace App\domain\Services\SecretCreateService;

use App\domain\Services\ServiceRequest;
use App\domain\ValueObjects\SecretId\SecretId;

class SecretCreateServiceRequest implements ServiceRequest
{
    private $secretId;
    private $message;
    private $protocol;
    private $domain;

    public function setSecretId(SecretId $secretId): void
    {
        $this->secretId = $secretId;
    }

    public function getSecretId()
    {
        return $this->secretId;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setProtocol(string $protocol): void
    {
        $this->protocol = $protocol;
    }
    public function getProtocol()
    {
        return $this->protocol;
    }

    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    public function getDomain()
    {
        return $this->domain;
    }

}