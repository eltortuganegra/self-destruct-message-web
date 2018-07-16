<?php

namespace App\domain\Services\SecretShowAndDestroyService;


use App\domain\Entities\Secret\Secret;
use App\domain\Services\ServiceResponse;
use App\domain\ValueObjects\LinkForShare\LinkForShare;

class SecretUnveilResponse implements ServiceResponse
{
    private $secret;
    private $linkForShare;

    public function __construct(Secret $secret, LinkForShare $linkForShare)
    {
        $this->secret = $secret;
        $this->linkForShare = $linkForShare;
    }

    public function getSecret(): Secret
    {
        return $this->secret;
    }

    public function getLinkForShare()
    {
        return $this->linkForShare;
    }
}