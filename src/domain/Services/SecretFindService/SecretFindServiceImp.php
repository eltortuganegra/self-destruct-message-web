<?php

namespace App\domain\Services\SecretFindService;


use App\domain\Entities\Secret\Secret;
use App\domain\Infrastructure\Repositories\SecretRepository;
use App\domain\Services\SecretUnveilService\SecretNotFoundException;
use App\domain\Services\Service;
use App\domain\Services\ServiceRequest;
use App\domain\Services\ServiceResponse;
use DateTime;

class SecretFindServiceImp implements Service, SecretFindService
{
    private $secretRepository;

    public function __construct(SecretRepository $secretRepository)
    {
        $this->secretRepository = $secretRepository;
    }

    public function execute(ServiceRequest $serviceRequest): ServiceResponse
    {
        $secretId = $serviceRequest->getSecretId();
        $secret = $this->secretRepository->findBySecretId($secretId);

        if ($this->isSecretNotFound($secret)) {
            throw new SecretNotFoundException();
        }

        if ($this->isSecretExpired($secret)) {
            throw new SecretIsExpiredException();
        }

        return new SecretFindServiceResponse($secret);
    }

    private function isSecretNotFound($secret): bool
    {
        return empty($secret);
    }

    private function isSecretExpired(Secret $secret): bool
    {
        return $secret->getExpirationDate() > new DateTime();
    }
}