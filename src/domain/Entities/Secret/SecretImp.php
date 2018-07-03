<?php

namespace App\domain\Entities\Secret;


use App\domain\ValueObjects\Message\Message;
use App\domain\ValueObjects\SecretId\SecretId;

class SecretImp implements Secret
{
    private $secretId;
    private $message;
    private $linkForShare;

    public function __construct(SecretId $secretId, Message $message)
    {
        $this->secretId = $secretId;
        $this->message = $message;
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

}