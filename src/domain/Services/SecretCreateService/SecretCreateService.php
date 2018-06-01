<?php

namespace App\domain\Services\SecretCreateService;


use App\domain\Entities\Secret\SecretFactory;
use App\domain\Services\Service;
use App\domain\Services\ServiceRequest;
use App\domain\Services\ServiceResponse;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactory;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactoryImp;

class SecretCreateService implements Service
{
    private $secretFactory;
    private $linkForShareFactory;

    public function __construct(SecretFactory $secretFactory, LinkForShareFactory $linkForShareFactory)
    {
        $this->secretFactory = $secretFactory;
        $this->linkForShareFactory = $linkForShareFactory;
    }

    public function execute(ServiceRequest $serviceRequest): ServiceResponse
    {
        $secret = $this->secretFactory->create($serviceRequest->getSecretId(), $serviceRequest->getMessage());
        $linkForShare = $this->linkForShareFactory->create(
            $serviceRequest->getProtocol(),
            $serviceRequest->getDomain(),
            $secret->getSecretId()->getIdentifier()
        );

        return new SecretCreateServiceResponse($secret, $linkForShare);
    }
}