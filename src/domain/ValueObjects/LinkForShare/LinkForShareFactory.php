<?php

namespace App\domain\ValueObjects\LinkForShare;


class LinkForShareFactory
{
    static public function create(string $protocol, string $domain, string $identifier): LinkForShare
    {
        return new LinkForShareImp($protocol, $domain, $identifier);
    }
}