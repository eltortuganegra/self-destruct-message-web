<?php

use App\domain\Entities\EntitiesFactory;
use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\DoctrineSecretRepository;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\ValueObjectsFactory;
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
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $message = $messageFactory->create($messageText);
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $this->secretId = $secretIdFactory->create($identifier);
        $secretFactory = EntitiesFactory::getSecretFactory();
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();
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
        $expirationDate = $this->secret->getExpirationDate()->format('Y-m-d H:i:s');
        $result = $this->secretRepository->findBySecretId($this->secretId);

        // Act
        $returnedExpirationDate = $result->getExpirationDate()->format('Y-m-d H:i:s');

        // Assert
        $this->assertEquals($expirationDate, $returnedExpirationDate);
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