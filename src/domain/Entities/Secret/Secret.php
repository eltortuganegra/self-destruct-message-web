<?php

namespace App\domain\Entities\Secret;

use App\domain\ValueObjects\SecretId\SecretId;

interface Secret
{
    public function getSecretId(): SecretId;
    public function getMessage(): string;
    public function getLinkForShare(): string;
}