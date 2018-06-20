<?php

namespace App\tests\domain\Services;


use App\domain\Entities\Secret\Secret;
use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\MemorySecretRepository;
use App\domain\Services\SecretCreateService\SecretCreateService;
use App\domain\Services\SecretCreateService\SecretCreateServiceRequest;

use App\domain\Services\ServiceResponse;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
use PHPUnit\Framework\TestCase;

class SecretCreateServiceTest extends TestCase
{
    private $service;
    private $request;
    private $response;

    public function setUp()
    {
        $this->buildRequest();
        $this->buildService();
        $this->executeService();
    }

    private function buildRequest(): void
    {
        $identifier = '1234';
        $secretIdFactory = new SecretIdFactoryImp();
        $secretId = $secretIdFactory->create($identifier);
        $message = 'This is a secret.';
        $protocol = 'https';
        $domain = 'sharedsecrets.eltortuganegra.com';
        $this->request = new SecretCreateServiceRequest();
        $this->request->setSecretId($secretId);
        $this->request->setMessage($message);
        $this->request->setProtocol($protocol);
        $this->request->setDomain($domain);
    }

    private function buildService(): void
    {
        $secretFactory = new SecretFactoryImp();
        $linkForShareFactory = new LinkForShareFactoryImp();
        $memoryRepository = new MemorySecretRepository();
        $this->service = new SecretCreateService($secretFactory, $linkForShareFactory, $memoryRepository);
    }

    private function executeService()
    {
        $this->response = $this->service->execute($this->request);
    }

    public function testServiceMustReturnAServiceResponse()
    {
        // Act
        $isAServiceResponse = $this->response instanceof ServiceResponse;

        // Assert
        $this->assertEquals(true, $isAServiceResponse);
    }

    public function testResponseMustContentTheCreatedSecret()
    {
        // Arrange
        $secret = $this->response->getSecret();

        // Act
        $isInstanceOfSecret = $secret instanceof Secret;

        // Assert
        $this->assertEquals(true, $isInstanceOfSecret);
    }

    public function testResponseMustContentSecretIdOfTheCreatedSecret()
    {
        // Arrange
        $secret = $this->response->getSecret();

        // Act
        $secretId = $secret->getSecretId();

        // Assert
        $this->assertEquals('1234', $secretId->getIdentifier());
    }

    public function testResponseMustContentMessageOfTheCreatedSecret()
    {
        // Arrange
        $secret = $this->response->getSecret();

        // Act
        $message = $secret->getMessage();

        // Assert
        $this->assertEquals('This is a secret.', $message);
    }

    public function testResponseMustContentLinkForShareOfTheCreatedSecret()
    {
        // Arrange
        $linkForShare = $this->response->getLinkForShare();

        // Act
        $url = $linkForShare->getUrl();

        // Assert
        $this->assertEquals('https://sharedsecrets.eltortuganegra.com/secret/1234', $url);
    }

}