<?php

use App\domain\Infrastructure\Mailers\MailerFactory;
use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\Services\SecretCreateService\SecretCreateService;
use App\domain\Services\SecretDeleteService\SecretDeleteService;
use App\domain\Services\SecretUnveilService\SecretUnveilService;
use App\domain\Services\ServicesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;

class ServicesFactoryTest extends TestCase
{
    public function testShouldReturnASecretCreateService()
    {
        // Arrange
        $secretRepository = RepositoriesFactory::getMemorySecretRepository();
        $mailer = MailerFactory::createMemoryMailer();
        $service = ServicesFactory::createSecretCreateService($secretRepository, $mailer);

        // Act
        $isServiceASecretCreateService = $service instanceof SecretCreateService;

        // Assert
        $this->assertEquals(true, $isServiceASecretCreateService);
    }

    public function testShouldReturnASecretDeleteService()
    {
        // Arrange
        $secretRepository = RepositoriesFactory::getMemorySecretRepository();
        $service = ServicesFactory::createSecretDeleteService($secretRepository);

        // Act
        $isServiceASecretCreateService = $service instanceof SecretDeleteService;

        // Assert
        $this->assertEquals(true, $isServiceASecretCreateService);
    }

    public function testShouldReturnASecretUnveilService()
    {
        // Arrange
        $secretRepository = RepositoriesFactory::getMemorySecretRepository();
        $service = ServicesFactory::createSecretUnveilService($secretRepository);

        // Act
        $isServiceASecretShowAndDestroyService = $service instanceof SecretUnveilService;

        // Assert
        $this->assertEquals(true, $isServiceASecretShowAndDestroyService);
    }

}