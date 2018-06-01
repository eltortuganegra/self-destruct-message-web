<?php

namespace App\domain\Services\SecretCreateService;


use App\domain\Entities\Secret\SecretFactory;
use App\domain\Services\Service;
use App\domain\Services\ServiceRequest;
use App\domain\Services\ServiceResponse;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactory;

class SecretCreateService implements Service
{
    private $secretFactory;

    public function __construct(SecretFactory $secretFactory)
    {
        $this->secretFactory = $secretFactory;
    }

    public function execute(ServiceRequest $serviceRequest): ServiceResponse
    {
        $secret = $this->secretFactory->create($serviceRequest->getSecretId(), $serviceRequest->getMessage());
        $linkForShare = LinkForShareFactory::create(
            $serviceRequest->getProtocol(),
            $serviceRequest->getDomain(),
            $secret->getSecretId()->getIdentifier()
        );

        return new SecretCreateServiceResponse($secret, $linkForShare);
    }
}