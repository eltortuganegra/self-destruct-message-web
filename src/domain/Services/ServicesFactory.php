<?php

namespace App\domain\Services;


use App\domain\Infrastructure\Repositories\SecretRepository;
use App\domain\Services\SecretDeleteService\SecretDeleteService;

class ServicesFactory
{
    static public function createSecretDeleteService(SecretRepository $secretRepository): Service
    {
        $service = new SecretDeleteService($secretRepository);

        return $service;
    }

}