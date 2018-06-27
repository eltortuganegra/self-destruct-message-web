<?php

namespace App\domain\Services\SecretShowAndDestroyService;

use App\domain\Infrastructure\Repositories\SecretRepository;
use App\domain\Services\Service;
use App\domain\Services\ServiceRequest;
use App\domain\Services\ServiceResponse;

class SecretShowAndDestroyService implements Service
{
    private $secretRepository;

    public function __construct(SecretRepository $secretRepository)
    {
        $this->secretRepository = $secretRepository;
    }

    public function execute(ServiceRequest $serviceRequest): ServiceResponse
    {
        $secretId = $serviceRequest->getSecretId();
        $secret = $this->secretRepository->getBySecretId($secretId);

        return new SecretShowAndDestroyServiceResponse($secret);
    }

}