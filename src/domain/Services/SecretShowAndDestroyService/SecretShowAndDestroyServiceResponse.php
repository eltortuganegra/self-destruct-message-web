<?php

namespace App\domain\Services\SecretShowAndDestroyService;


use App\domain\Entities\Secret\Secret;
use App\domain\Services\ServiceResponse;

class SecretShowAndDestroyServiceResponse implements ServiceResponse
{
    private $secret;

    public function __construct(Secret $secret)
    {
        $this->secret = $secret;
    }

    public function getSecret(): Secret
    {
        return $this->secret;
    }
}