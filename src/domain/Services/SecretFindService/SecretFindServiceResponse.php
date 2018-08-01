<?php

namespace App\domain\Services\SecretFindService;


use App\domain\Entities\Secret\Secret;
use App\domain\Services\ServiceResponse;

class SecretFindServiceResponse implements ServiceResponse
{
    private $secret;

    public function __construct(Secret $secret)
    {
        $this->secret = $secret;
    }

    public function getSecret()
    {
        return $this->secret;
    }
}