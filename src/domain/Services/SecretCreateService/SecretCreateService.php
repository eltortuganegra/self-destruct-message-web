<?php

namespace App\domain\Services\SecretCreateService;


use App\domain\Entities\Secret\SecretFactory;
use App\domain\Infrastructure\Repositories\SecretRepository;
use App\domain\Services\Service;
use App\domain\Services\ServiceRequest;
use App\domain\Services\ServiceResponse;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactory;

class SecretCreateService implements Service
{
    private $secretFactory;
    private $linkForShareFactory;
    private $secretRepository;
    private $secret;
    private $serviceRequest;

    public function __construct(SecretFactory $secretFactory, LinkForShareFactory $linkForShareFactory, SecretRepository $secretRepository)
    {
        $this->secretFactory = $secretFactory;
        $this->linkForShareFactory = $linkForShareFactory;
        $this->secretRepository = $secretRepository;
    }

    public function execute(ServiceRequest $serviceRequest): ServiceResponse
    {
        $this->loadServiceRequest($serviceRequest);
        $this->createSecretFromServiceRequest();
        $this->persistSecret();
        $response = $this->buildResponse();

        return $response;
    }

    private function createSecretFromServiceRequest()
    {
        $this->secret = $this->secretFactory->create(
            $this->serviceRequest->getSecretId(),
            $this->serviceRequest->getMessage()
        );
    }

    private function persistSecret(): void
    {
        $this->secretRepository->add($this->secret);
    }

    private function buildResponse(): SecretCreateServiceResponse
    {
        $secret = $this->secretRepository->getBySecretId($this->secret->getSecretId());
        $linkForShare = $this->linkForShareFactory->create(
            $this->serviceRequest->getProtocol(),
            $this->serviceRequest->getDomain(),
            $this->secret->getSecretId()->getIdentifier()
        );
        $response = new SecretCreateServiceResponse($secret, $linkForShare);

        return $response;
    }

    private function loadServiceRequest(ServiceRequest $serviceRequest): void
    {
        $this->serviceRequest = $serviceRequest;
    }
}