<?php

use App\domain\Entities\EntitiesFactory;
use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;

class FindSecretsInMemorySecretRepositoryTest extends TestCase
{
    private $secretOne;
    private $secretTwo;
    private $secretRepository;

    public function setUp()
    {
        $this->loadSecretRepository();
        $this->loadSecretOne();
        $this->loadSecretTwo();
        $this->addSecretsToRepository();
    }

    private function loadSecretRepository(): void
    {
        $this->secretRepository = RepositoriesFactory::getMemorySecretRepository();
    }

    private function loadSecretOne(): void
    {
        $secretFactory = EntitiesFactory::getSecretFactory();
        $secretId = $this->secretRepository->nextIdentity();
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $messageText = 'This is a valid message';
        $message = $messageFactory->create($messageText);
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();
        $expirationTimeInSeconds = 120;
        $expirationTime = $expirationTimeFactory->create($expirationTimeInSeconds);
        $this->secretOne = $secretFactory->create($secretId, $message, $expirationTime);
    }

    private function loadSecretTwo(): void
    {
        $secretFactory = EntitiesFactory::getSecretFactory();
        $secretId = $this->secretRepository->nextIdentity();
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $messageText = 'This is a valid message';
        $message = $messageFactory->create($messageText);
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();
        $expirationTimeInSeconds = 120;
        $expirationTime = $expirationTimeFactory->create($expirationTimeInSeconds);
        $this->secretTwo = $secretFactory->create($secretId, $message, $expirationTime);
    }

    private function addSecretsToRepository(): void
    {
        $this->secretRepository->add($this->secretOne);
        $this->secretRepository->add($this->secretTwo);
    }

    public function testShouldFindASecretToRepository()
    {
        // Arrange


        // Act
        $result = $this->secretRepository->findBySecretId($this->secretTwo->getSecretId());

        // Assert
        $this->assertEquals($this->secretTwo, $result);
    }

}