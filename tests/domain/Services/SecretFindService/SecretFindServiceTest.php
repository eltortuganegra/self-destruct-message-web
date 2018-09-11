<?php

use App\domain\Infrastructure\Mailers\MailerFactory;
use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\Services\SecretCreateService\SecretCreateServiceRequest;
use App\domain\Services\SecretFindService\SecretFindServiceRequest;
use App\domain\Services\ServicesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;

class SecretFindServiceTest extends TestCase
{
    private $repository;
    private $mailer;
    private $request;
    private $createService ;
    private $secret;
    private $secretFindServiceRequest;

    public function testItShouldReturnTheSecretWhenSecretExistInRepository()
    {
        // Arrange
        $this->loadRepository();
        $this->loadMailer();
        $this->buildRequest();
        $this->buildCreateService();
        $this->executeCreateService();
        $this->createSecretFindServiceRequest();
        $service = ServicesFactory::createSecretFindService($this->repository);
        $response = $service->execute($this->secretFindServiceRequest);

        // Act
        $returnedSecret = $response->getSecret();

        // Assert
        $this->assertEquals($this->secret, $returnedSecret);
    }

    private function loadMailer(): void
    {
        $this->mailer = MailerFactory::createMemoryMailer();
    }

    private function buildCreateService(): void
    {
        $this->createService = ServicesFactory::createSecretCreateService($this->repository, $this->mailer);
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
        $this->request->setExpirationTimeInSeconds(300);
    }

    private function loadRepository(): void
    {
        $this->repository = RepositoriesFactory::getMemorySecretRepository();
    }

    private function executeCreateService(): void
    {
        $response = $this->createService->execute($this->request);
        $this->secret = $response->getSecret();
    }

    private function createSecretFindServiceRequest(): void
    {
        $this->secretFindServiceRequest= new SecretFindServiceRequest($this->secret->getSecretId()->getIdentifier());
    }

}
