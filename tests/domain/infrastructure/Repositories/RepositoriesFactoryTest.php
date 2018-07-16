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

//    public function testShouldReturnDoctrineSecretRepository()
//    {
//        // Arrange
//        $secretRepository = RepositoriesFactory::getDoctrineSecretRepository();
//
//        // Act
//        $isSecretRepository = $secretRepository instanceof SecretRepository;
//
//        // Assert
//        $this->assertEquals(true, $isSecretRepository);
//    }
}