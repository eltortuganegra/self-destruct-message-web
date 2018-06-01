<?php

namespace App\domain\ValueObjects\SecretId;


interface SecretId
{
    public function getIdentifier(): string;
}