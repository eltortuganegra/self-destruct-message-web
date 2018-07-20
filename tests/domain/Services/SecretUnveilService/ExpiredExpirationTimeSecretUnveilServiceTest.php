<?php

use App\domain\Entities\EntitiesFactory;
use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\Services\SecretUnveilService\ExpirationTimeIsExpiredException;
use App\domain\Services\SecretUnveilService\SecretUnveilServiceRequest;
use App\domain\Services\ServicesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;

class ExpiredExpirationTimeSecretUnveilServiceTest extends TestCase
{
    private $service;
    private $serviceResponse;
    private $serviceRequest;
    private $secret;
    private $secretRepository;

    public function setUp()
    {
        $this->loadSecretRepository();
        $this->createDefaultSecret();
        $this->addSecretToTheRepository();
        $this->buildServiceRequest();
        $this->buildSecretUnveilService();
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
        $expirationTimeInSeconds = 1;
        $expirationTime = $expirationTimeFactory->create($expirationTimeInSeconds);

        return $expirationTime;
    }

    private function generateSecret($secretId, $message, $expirationTime): void
    {
        $secretFactory = EntitiesFactory::getSecretFactory();
        $expiredExpirationDate = new DateTime('1990-10-15');
        $this->secret = $secretFactory->createFromRepository($secretId, $message, $expirationTime, $expiredExpirationDate);
    }

    private function addSecretToTheRepository(): void
    {
        $this->secretRepository->add($this->secret);
    }

    private function buildServiceRequest(): void
    {
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $this->serviceRequest = new SecretUnveilServiceRequest($secretIdFactory);
        $this->serviceRequest->setIdentifier($this->secret->getSecretId()->getIdentifier());
        $this->serviceRequest->setDomain('test.com');
        $this->serviceRequest->setProtocol('https');
    }

    private function buildSecretUnveilService(): void
    {
        $this->service = ServicesFactory::createSecretUnveilService($this->secretRepository);
    }

    public function testShouldRemoveSecretFromRepositoryIfItIsExpired()
    {
        // Assert
        $this->expectException(ExpirationTimeIsExpiredException::class);

        // Act
        $this->serviceResponse = $this->service->execute($this->serviceRequest);
    }
}