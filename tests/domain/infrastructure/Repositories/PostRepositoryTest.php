<?php


use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\MemorySecretRepository;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PostRepositoryTest extends TestCase
{
    public function testSecretRepositoryMustCanPersistAPost()
    {
        // Arrange
        $identifier = Uuid::uuid4();
        $message = 'This is a secret message.';
        $secretIdFactory = new SecretIdFactoryImp();
        $secretId = $secretIdFactory->create($identifier);
        $secretFactory = new SecretFactoryImp();
        $secret = $secretFactory->create($secretId, $message);
        $secretRepository = new MemorySecretRepository($secretIdFactory);
        $secretRepository->add($secret);

        // Act
        $result = $secretRepository->findBySecretId($secretId);

        // Assert
        $this->assertEquals($secret, $result);
    }

}
