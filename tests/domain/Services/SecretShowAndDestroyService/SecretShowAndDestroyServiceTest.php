<?php


use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\MemorySecretRepository;
use App\domain\Services\SecretShowAndDestroyService\SecretShowAndDestroyService;
use App\domain\Services\SecretShowAndDestroyService\SecretShowAndDestroyServiceRequest;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactoryImp;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
use PHPUnit\Framework\TestCase;

class SecretShowAndDestroyServiceTest extends TestCase
{
    private $serviceResponse;
    private $secret;
    private $secretRepository;

    public function setUp()
    {
        $identifier = Ramsey\Uuid\Uuid::uuid4();
        $secretIdFactory = new SecretIdFactoryImp();
        $secretId = $secretIdFactory->create($identifier);
        $secretFactory = new SecretFactoryImp();
        $messageText = 'This is awesome secret message.';
        $messageFactory = new MessageFactoryImp();
        $message = $messageFactory->create($messageText);
        $expirationTimeFactory = new ExpirationTimeFactoryImp();
        $expirationTimeInSeconds = 120;
        $expirationTime = $expirationTimeFactory->create($expirationTimeInSeconds);
        $this->secret = $secretFactory->create($secretId, $message, $expirationTime);

        $this->secretRepository = new MemorySecretRepository($secretIdFactory);
        $this->secretRepository->add($this->secret);

        $serviceRequest = new SecretShowAndDestroyServiceRequest($secretIdFactory);
        $serviceRequest->setIdentifier($identifier);
        $serviceRequest->setDomain('test.com');
        $serviceRequest->setProtocol('https');

        $linkForShareFactory = new LinkForShareFactoryImp();

        $service = new SecretShowAndDestroyService($this->secretRepository, $linkForShareFactory);
        $this->serviceResponse = $service->execute($serviceRequest);
    }

    public function testServiceMustReturnSecret()
    {
        // Act
        $returnedSecret = $this->serviceResponse->getSecret();

        // Assert
        $this->assertEquals($this->secret, $returnedSecret);
    }

    public function testServiceMustDeleteReturnedSecret()
    {
        // Arrange
        $secretId = $this->secret->getSecretId();

        // Act
        $returnedSecret = $this->secretRepository->findBySecretId($secretId);

        // Assert
        $this->assertEquals(null, $returnedSecret);
    }
}
