<?php

namespace App\domain\Services\SecretShowAndDestroyService;

use App\domain\Infrastructure\Repositories\SecretRepository;
use App\domain\Services\Service;
use App\domain\Services\ServiceRequest;
use App\domain\Services\ServiceResponse;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactory;

class SecretShowAndDestroyServiceImp implements Service, SecretShowAndDestroyService
{
    private $secretRepository;
    private $linkForShareFactory;

    public function __construct(SecretRepository $secretRepository, LinkForShareFactory $linkForShareFactory)
    {
        $this->secretRepository = $secretRepository;
        $this->linkForShareFactory = $linkForShareFactory;
    }

    public function execute(ServiceRequest $serviceRequest): ServiceResponse
    {

        $secretId = $serviceRequest->getSecretId();
        $secret = $this->secretRepository->findBySecretId($secretId);

        if (empty($secret)) {
            throw new SecretNotFoundException('WTF');
        }

        $linkForShare = $this->linkForShareFactory->create(
            $serviceRequest->getProtocol(),
            $serviceRequest->getDomain(),
            $serviceRequest->getIdentifier()
        );

        $this->secretRepository->remove($secret);

        return new SecretShowAndDestroyServiceResponse($secret, $linkForShare);
    }

}