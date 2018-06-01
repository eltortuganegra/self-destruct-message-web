<?php

namespace App\tests\domain\Services;

use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Services\SecretCreateService\SecretCreateService;
use App\domain\Services\SecretCreateService\SecretCreateServiceRequest;

use App\domain\Services\ServiceResponse;
use App\domain\ValueObjects\SecretId\SecretIdFactory;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;


class SecretCreateServiceTest extends TestCase
{
    public function testServiceMustReturnAServiceResponse()
    {
        // Arrange
        $secretFactory = new SecretFactoryImp();
        $service = new SecretCreateService($secretFactory);
        $identifier = Uuid::uuid4();
        $secretId = SecretIdFactory::create($identifier);
        $message = 'This is a secret.';
        $protocol = 'http';
        $domain = 'thisisatest.com';
        $secretCreateServiceRequest = new SecretCreateServiceRequest();
        $secretCreateServiceRequest->setSecretId($secretId);
        $secretCreateServiceRequest->setMessage($message);
        $secretCreateServiceRequest->setProtocol($protocol);
        $secretCreateServiceRequest->setDomain($domain);

        $secretCreateServiceResponse = $service->execute($secretCreateServiceRequest);

        // Act
        $isAServiceResponse = $secretCreateServiceResponse instanceof ServiceResponse;

        // Assert
        $this->assertEquals(true, $isAServiceResponse);
    }
}