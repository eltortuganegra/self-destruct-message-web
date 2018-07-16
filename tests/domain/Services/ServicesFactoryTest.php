<?php

use App\domain\Infrastructure\Repositories\MemorySecretRepository;
use App\domain\Services\SecretCreateService\SecretCreateService;
use App\domain\Services\SecretDeleteService\SecretDeleteService;
use App\domain\Services\SecretShowAndDestroyService\SecretShowAndDestroyService;
use App\domain\Services\ServicesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;

class ServicesFactoryTest extends TestCase
{
    public function testShouldReturnASecretCreateService()
    {
        // Arrange
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretRepository = new MemorySecretRepository($secretIdFactory);
        $service = ServicesFactory::createSecretCreateService($secretRepository);

        // Act
        $isServiceASecretCreateService = $service instanceof SecretCreateService;

        // Assert
        $this->assertEquals(true, $isServiceASecretCreateService);
    }

    public function testShouldReturnASecretDeleteService()
    {
        // Arrange
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretRepository = new MemorySecretRepository($secretIdFactory);
        $service = ServicesFactory::createSecretDeleteService($secretRepository);

        // Act
        $isServiceASecretCreateService = $service instanceof SecretDeleteService;

        // Assert
        $this->assertEquals(true, $isServiceASecretCreateService);
    }

    public function testShouldReturnASecretShowAndDestroyService()
    {
        // Arrange
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretRepository = new MemorySecretRepository($secretIdFactory);
        $service = ServicesFactory::createSecretShowAndDestroyService($secretRepository);

        // Act
        $isServiceASecretShowAndDestroyService = $service instanceof SecretShowAndDestroyService;

        // Assert
        $this->assertEquals(true, $isServiceASecretShowAndDestroyService);
    }

}