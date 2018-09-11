<?php

namespace App\tests\domain\Services;


use App\domain\Entities\Secret\Secret;
use App\domain\Infrastructure\Mailers\MailerFactory;
use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\Services\SecretCreateService\SecretCreateServiceRequest;
use App\domain\Services\ServiceResponse;
use App\domain\Services\ServicesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
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
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretId = $secretIdFactory->create($identifier);
        $message = 'This is a secret.';
        $protocol = 'https';
        $domain = 'sharedsecrets.eltortuganegra.com';
        $this->request = new SecretCreateServiceRequest();
        $this->request->setSecretId($secretId);
        $this->request->setMessage($message);
        $this->request->setProtocol($protocol);
        $this->request->setDomain($domain);
        $this->request->setExpirationTimeInSeconds(60);
    }

    private function buildService(): void
    {
        $memoryRepository = RepositoriesFactory::getMemorySecretRepository();
        $memoryMailer = MailerFactory::createMemoryMailer();
        $this->service = ServicesFactory::createSecretCreateService($memoryRepository, $memoryMailer);
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
        $this->assertNotNull($secretId->getIdentifier());
    }

    public function testResponseMustContentMessageOfTheCreatedSecret()
    {
        // Arrange
        $secret = $this->response->getSecret();

        // Act
        $message = $secret->getMessage();

        // Assert
        $this->assertEquals('This is a secret.', $message->getContent());
    }

    public function testResponseMustContentLinkForShareOfTheCreatedSecret()
    {
        // Arrange
        $linkForShare = $this->response->getLinkForShare();
        $secret = $this->response->getSecret();
        $expectedUrl = 'https://sharedsecrets.eltortuganegra.com/secret/' . $secret->getSecretId()->getIdentifier();

        // Act
        $url = $linkForShare->getUrl();

        // Assert
        $this->assertEquals($expectedUrl, $url);
    }

}