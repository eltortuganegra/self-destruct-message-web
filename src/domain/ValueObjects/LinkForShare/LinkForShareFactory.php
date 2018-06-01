<?php

namespace App\domain\ValueObjects\LinkForShare;


interface LinkForShareFactory
{
    public function create(string $protocol, string $domain, string $identifier): LinkForShare;
}