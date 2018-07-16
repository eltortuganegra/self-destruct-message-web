<?php

use App\domain\Entities\EntitiesFactory;
use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\DoctrineSecretRepository;
use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\SecretId\SecretId;
use App\domain\ValueObjects\ValueObjectsFactory;
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