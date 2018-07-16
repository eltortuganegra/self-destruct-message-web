<?php

use App\domain\Entities\EntitiesFactory;
use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\MemorySecretRepository;
use App\domain\Services\SecretShowAndDestroyService\SecretShowAndDestroyServiceRequest;
use App\domain\Services\ServicesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;

class SecretShowAndDestroyServiceTest extends TestCase
{
    private $serviceResponse;
    private $secret;
    private $secretRepository;

    public function setUp()
    {
        $identifier = Ramsey\Uuid\Uuid::uuid4();
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretId = $secretIdFactory->create($identifier);
        $secretFactory = EntitiesFactory::getSecretFactory();
        $messageText = 'This is awesome secret message.';
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $message = $messageFactory->create($messageText);
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();
        $expirationTimeInSeconds = 120;
        $expirationTime = $expirationTimeFactory->create($expirationTimeInSeconds);
        $this->secret = $secretFactory->create($secretId, $message, $expirationTime);

        $this->secretRepository = new MemorySecretRepository($secretIdFactory);
        $this->secretRepository->add($this->secret);

        $serviceRequest = new SecretShowAndDestroyServiceRequest($secretIdFactory);
        $serviceRequest->setIdentifier($identifier);
        $serviceRequest->setDomain('test.com');
        $serviceRequest->setProtocol('https');

        $service = ServicesFactory::createSecretShowAndDestroyService($this->secretRepository);
        $this->serviceResponse = $service->execute($serviceRequest);
    }

    public function testServiceMustReturnSecret()
    {
        // Act
        $returnedSecret = $this->serviceResponse->getSecret();

        // Assert
        $this->assertEquals($this->secret, $returnedSecret);
    }

    public function testServiceMustDeleteReturnedSecret()
    {
        // Arrange
        $secretId = $this->secret->getSecretId();

        // Act
        $returnedSecret = $this->secretRepository->findBySecretId($secretId);

        // Assert
        $this->assertEquals(null, $returnedSecret);
    }
}
