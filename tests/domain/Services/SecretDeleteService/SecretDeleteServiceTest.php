<?php

namespace App\tests\domain\Services;

use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\MemorySecretRepository;
use App\domain\Services\SecretDeleteService\SecretDeleteServiceRequest;
use App\domain\Services\ServicesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;

class SecretDeleteServiceTest extends TestCase
{
    public function testShouldRemoveSecretFromRepositoryWhenServiceIsExecute()
    {
        // Arrange
        $identifier = 'valid identifier';
        $message = 'valid message';
        $expirationTime = 60;
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretId = $secretIdFactory->create($identifier);
        $secretFactory = new SecretFactoryImp();
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $message = $messageFactory->create($message);
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();
        $expirationDate = $expirationTimeFactory->create($expirationTime);
        $secret = $secretFactory->create($secretId, $message, $expirationDate );
        $secretRepository = new MemorySecretRepository($secretIdFactory);
        $secretRepository->add($secret);

        $serviceRequest = new SecretDeleteServiceRequest($identifier);
        $service = ServicesFactory::createSecretDeleteService($secretRepository);
        $serviceResponse = $service->execute($serviceRequest);

        // Act
        $result = $secretRepository->findBySecretId($secretId);

        // Assert
        $this->assertEquals(null, $result);
    }

}