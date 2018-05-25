<?php

namespace App\domain\Entities\Secret;


use App\domain\ValueObjects\Secret\SecretId;

class SecretImp implements Secret
{
    private $secretId;
    private $message;

    public function __construct(SecretId $secretId, string $message)
    {
        $this->secretId = $secretId;
        $this->message = $message;
    }

    public function getSecretId(): SecretId
    {
        return $this->secretId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

}