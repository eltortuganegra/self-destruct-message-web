<?php

use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\DoctrineSecretRepository;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\SecretId\SecretId;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
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
        $secretFactory = new SecretFactoryImp();
        $secretIdFactory = new SecretIdFactoryImp();
        $messageFactory = new MessageFactoryImp();
        $expirationTimeFactory = new ExpirationTimeFactoryImp();
        $this->secretRepository = new DoctrineSecretRepository(
            $entityManager,
            $secretFactory,
            $secretIdFactory,
            $messageFactory,
            $expirationTimeFactory
        );
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