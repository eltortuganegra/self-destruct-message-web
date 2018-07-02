<?php

use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\DoctrineSecretRepository;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SecretRepositoryTest extends KernelTestCase
{
    public function testSecretMustCanBePersisted()
    {
        // Arrange
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $identifier = Uuid::uuid4();
        $message = 'This is a secret message.';
        $secretIdFactory = new SecretIdFactoryImp();
        $secretId = $secretIdFactory->create($identifier);
        $secretFactory = new SecretFactoryImp();
        $secret = $secretFactory->create($secretId, $message);
        $secretRepository = new DoctrineSecretRepository($entityManager, $secretFactory, $secretIdFactory);
        $secretRepository->add($secret);

        // Act
        $result = $secretRepository->getBySecretId($secretId);

        // Assert
        $this->assertEquals($secret, $result);
    }

    public function testShouldRemoveASecretFromRepository()
    {
        // Arrange
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $identifier = Uuid::uuid4();
        $message = 'This is a secret message.';
        $secretIdFactory = new SecretIdFactoryImp();
        $secretId = $secretIdFactory->create($identifier);
        $secretFactory = new SecretFactoryImp();
        $secret = $secretFactory->create($secretId, $message);
        $secretRepository = new DoctrineSecretRepository($entityManager, $secretFactory, $secretIdFactory);
        $secretRepository->add($secret);
        $secretRepository->remove($secret);

        // Act
        $result = $secretRepository->getBySecretId($secretId);

        // Assert
        $this->assertEquals(null, $result);
    }

}