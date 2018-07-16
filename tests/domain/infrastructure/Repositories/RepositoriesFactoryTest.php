<?php

use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\Infrastructure\Repositories\SecretRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RepositoriesFactoryTest extends KernelTestCase
{
    public function testShouldReturnMemorySecretRepository()
    {
        // Arrange
        $secretRepository = RepositoriesFactory::getMemorySecretRepository();

        // Act
        $isSecretRepository = $secretRepository instanceof SecretRepository;

        // Assert
        $this->assertEquals(true, $isSecretRepository);
    }

    public function testShouldReturnDoctrineSecretRepository()
    {
        // Arrange
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $secretRepository = RepositoriesFactory::getDoctrineSecretRepository($entityManager);

        // Act
        $isSecretRepository = $secretRepository instanceof SecretRepository;

        // Assert
        $this->assertEquals(true, $isSecretRepository);
    }
}