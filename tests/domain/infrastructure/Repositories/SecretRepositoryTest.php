<?php

use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\DoctrineSecretRepository;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SecretRepositoryTest extends KernelTestCase
{
    private $secret;
    private $secretRepository;
    private $secretId;

    public function setUp()
    {
        // Arrange
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $identifier = Uuid::uuid4();
        $messageText = 'This is a secret message.';
        $messageFactory = new MessageFactoryImp();
        $message = $messageFactory->create($messageText);
        $secretIdFactory = new SecretIdFactoryImp();
        $this->secretId = $secretIdFactory->create($identifier);
        $secretFactory = new SecretFactoryImp();
        $expirationTimeFactory = new ExpirationTimeFactoryImp();
        $expirationSecretSeconds = 60;
        $expirationTime = $expirationTimeFactory->create($expirationSecretSeconds);
        $this->secret = $secretFactory->create($this->secretId, $message, $expirationTime);
        $messageFactory = new MessageFactoryImp();

        $this->secretRepository = new DoctrineSecretRepository(
            $entityManager,
            $secretFactory,
            $secretIdFactory,
            $messageFactory,
            $expirationTimeFactory
        );
    }

    public function testSecretMustCanBePersisted()
    {
        // Arrange
        $this->secretRepository->add($this->secret);

        // Act
        $result = $this->secretRepository->findBySecretId($this->secretId);

        // Assert
        $this->assertEquals($this->secret, $result);
    }

    public function testShouldRemoveASecretFromRepository()
    {
        // Arrange
        $this->secretRepository->add($this->secret);
        $this->secretRepository->remove($this->secret);

        // Act
        $result = $this->secretRepository->findBySecretId($this->secretId);

        // Assert
        $this->assertEquals(null, $result);
    }

}