<?php

namespace App\domain\Entities\Secret;

use App\domain\ValueObjects\ExpirationTime\ExpirationTime;
use App\domain\ValueObjects\Message\Message;
use App\domain\ValueObjects\SecretId\SecretId;

interface Secret
{
    public function getSecretId(): SecretId;
    public function getMessage(): Message;
    public function getLinkForShare(): string;
    public function getExpirationTime(): ExpirationTime;
}