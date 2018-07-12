<?php

namespace App\domain\Services\SecretCreateService;

use App\domain\Services\ServiceRequest;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\SecretId\SecretId;
use DateInterval;
use DateTime;
use Symfony\Component\Validator\Constraints\Date;

class SecretCreateServiceRequest implements ServiceRequest
{
    private $messageFactory;
    private $expirationTimeFactory;
    private $secretId;
    private $message;
    private $protocol;
    private $domain;
    private $expirationTime;

    public function __construct()
    {
        $this->messageFactory = new MessageFactoryImp();
        $this->expirationTimeFactory = new ExpirationTimeFactoryImp();
    }

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
        return $this->messageFactory->create($this->message);
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

    public function setExpirationTimeInSeconds(int $expirationTimeInSeconds)
    {
        $expirationDate = new DateTime();
        $expirationDate->add(new DateInterval('PT' . $expirationTimeInSeconds . 'S'));

        $this->expirationTime = $this->expirationTimeFactory->create($expirationDate);
    }

    public function getExpirationTime()
    {
        return $this->expirationTime;
    }

}