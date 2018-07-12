<?php

namespace App\domain\Entities\Secret;


use App\domain\ValueObjects\ExpirationTime\ExpirationTime;
use App\domain\ValueObjects\Message\Message;
use App\domain\ValueObjects\SecretId\SecretId;

class SecretImp implements Secret
{
    private $secretId;
    private $message;
    private $linkForShare;
    private $expirationTime;

    public function __construct(SecretId $secretId, Message $message, ExpirationTime $expirationTime)
    {
        $this->secretId = $secretId;
        $this->message = $message;
        $this->expirationTime = $expirationTime;
    }

    public function getSecretId(): SecretId
    {
        return $this->secretId;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getLinkForShare(): string
    {
        return $this->linkForShare;
    }

    public function getExpirationTime(): ExpirationTime
    {
        return $this->expirationTime;
    }
}