<?php

namespace App\domain\ValueObjects\LinkForShare;


class LinkForShareImp implements LinkForShare
{
    private $protocol;
    private $domain;
    private $identifier;

    public function __construct(string $protocol, string $domain, string $identifier)
    {
        $this->protocol = $protocol;
        $this->domain = $domain;
        $this->identifier = $identifier;
    }

    public function getUrl(): string
    {
        return $this->protocol . '://' . $this->domain . '/secret/' . $this->identifier;
    }

}