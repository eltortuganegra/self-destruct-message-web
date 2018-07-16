<?php


use App\domain\Entities\EntitiesFactory;
use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\MemorySecretRepository;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PostRepositoryTest extends TestCase
{
    public function testSecretRepositoryMustCanPersistAPost()
    {
        // Arrange
        $identifier = Uuid::uuid4();
        $messageText = 'This is a secret message.';
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $message = $messageFactory->create($messageText);
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretId = $secretIdFactory->create($identifier);
        $secretFactory = EntitiesFactory::getSecretFactory();
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();
        $expirationTimeInSeconds = 120;
        $expirationTime = $expirationTimeFactory->create($expirationTimeInSeconds);
        $secret = $secretFactory->create($secretId, $message, $expirationTime);

        $secretRepository = new MemorySecretRepository($secretIdFactory);
        $secretRepository->add($secret);

        // Act
        $result = $secretRepository->findBySecretId($secretId);

        // Assert
        $this->assertEquals($secret, $result);
    }

}
