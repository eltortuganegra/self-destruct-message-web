<?php

use App\domain\Entities\EntitiesFactory;
use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\Services\SecretUnveilService\SecretUnveilServiceRequest;
use App\domain\Services\ServicesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;

class SecretUnveilServiceTest extends TestCase
{
    private $serviceResponse;
    private $secret;
    private $secretRepository;

    public function setUp()
    {
        $this->loadSecretRepository();
        $this->createDefaultSecret();
        $this->addSecretToTheRepository();
        $serviceRequest = $this->buildServiceRequest();
        $service = $this->buildSecretUnveilService();
        $this->serviceResponse = $service->execute($serviceRequest);
    }

    private function createDefaultSecret(): void
    {
        $secretId = $this->generateSecretId();
        $message = $this->generateMessage();
        $expirationTime = $this->generateExpirationTime();
        $this->generateSecret($secretId, $message, $expirationTime);
    }

    private function loadSecretRepository(): void
    {
        $this->secretRepository = RepositoriesFactory::getMemorySecretRepository();
    }

    private function generateSecretId()
    {
        $secretId = $this->secretRepository->nextIdentity();

        return $secretId;
    }

    private function generateMessage(): \App\domain\ValueObjects\Message\Message
    {
        $messageText = 'This is awesome secret message.';
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $message = $messageFactory->create($messageText);

        return $message;
    }

    private function generateExpirationTime(): \App\domain\ValueObjects\ExpirationTime\ExpirationTime
    {
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();
        $expirationTimeInSeconds = 120;
        $expirationTime = $expirationTimeFactory->create($expirationTimeInSeconds);

        return $expirationTime;
    }

    private function generateSecret($secretId, $message, $expirationTime): void
    {
        $secretFactory = EntitiesFactory::getSecretFactory();
        $this->secret = $secretFactory->create($secretId, $message, $expirationTime);
    }

    private function addSecretToTheRepository(): void
    {
        $this->secretRepository->add($this->secret);
    }

    private function buildServiceRequest()
    {
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $serviceRequest = new SecretUnveilServiceRequest($secretIdFactory);
        $serviceRequest->setIdentifier($this->secret->getSecretId()->getIdentifier());
        $serviceRequest->setDomain('test.com');
        $serviceRequest->setProtocol('https');

        return $serviceRequest;
    }

    private function buildSecretUnveilService(): \App\domain\Services\Service
    {
        $service = ServicesFactory::createSecretUnveilService($this->secretRepository);

        return $service;
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