<?php

namespace App\domain\Entities\Secret;

use App\domain\ValueObjects\Secret\SecretId;

interface Secret
{
    public function getSecretId(): SecretId;
    public function getMessage(): string;
}