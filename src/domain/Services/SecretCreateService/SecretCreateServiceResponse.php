<?php

namespace App\domain\Services\SecretCreateService;


use App\domain\Entities\Secret\Secret;
use App\domain\Services\ServiceResponse;
use App\domain\ValueObjects\LinkForShare\LinkForShare;

class SecretCreateServiceResponse implements ServiceResponse
{
    private $secret;
    private $linkForShare;
    private $wasMailSent;

    public function __construct(Secret $secret, LinkForShare $linkForShare, bool $wasMailSent)
    {
        $this->secret = $secret;
        $this->linkForShare = $linkForShare;
        $this->wasMailSent = $wasMailSent;
    }

    public function getSecret(): Secret
    {
        return $this->secret;
    }

    public function getLinkForShare(): LinkForShare
    {
        return $this->linkForShare;
    }

    public function wasMailSent(): bool
    {
        return $this->wasMailSent;
    }

}