<?php

use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\ValueObjects\SecretId\SecretId;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineSecretRepositoryTest extends KernelTestCase
{
    private $secretRepository;

    public function setUp()
    {
        // Arrange
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->secretRepository = RepositoriesFactory::getDoctrineSecretRepository($entityManager);
    }

    public function testShouldReturnNextSecretId()
    {
        // Arrange
        $secretId = $this->secretRepository->nextIdentity();

        // Act
        $isSecretId = $secretId instanceof SecretId;

        // Assert
        $this->assertEquals(true, $isSecretId);
    }

}