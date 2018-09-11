<?php

namespace App\tests\domain\Services;


use App\domain\Infrastructure\Mailers\MailerFactory;
use App\domain\Infrastructure\Mailers\MemoryMailerFactoryInterfaceImp;
use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\Services\SecretCreateService\SecretCreateServiceRequest;
use App\domain\Services\ServicesFactory;
use PHPUnit\Framework\TestCase;

class ValidEmailSecretCreateServiceTest extends TestCase
{
    private $requestService;
    private $service;
    private $responseService;

    public function testItShouldCreateSecretAndSendMail()
    {
        // Arrange
        $this->buildRequestService();
        $this->buildService();
        $this->executeService();

        // Act
        $wasMailSent = $this->responseService->wasMailSent();

        // Assert
        $this->assertTrue($wasMailSent);

    }

    private function buildRequestService(): void
    {
        $message = 'This is de body of message';
        $expirationTime = 600;
        $protocol = 'http';
        $domain = 'sharedsecrets.eltortuganegra.com';
        $fromMail = 'no-reply@eltortuganegar.com';
        $toMail = 'test@eltortuganegra.com';

        $this->requestService = new SecretCreateServiceRequest();
        $this->requestService->setMessage($message);
        $this->requestService->setProtocol($protocol);
        $this->requestService->setDomain($domain);
        $this->requestService->setExpirationTimeInSeconds($expirationTime);
        $this->requestService->setFromMail($fromMail);
        $this->requestService->setToMail($toMail);
    }

    private function buildService(): void
    {
        $memoryRepository = RepositoriesFactory::getMemorySecretRepository();
        $memoryMailer = MailerFactory::createMemoryMailer();

        $this->service = ServicesFactory::createSecretCreateService($memoryRepository, $memoryMailer);
    }

    private function executeService(): void
    {
        $this->responseService = $this->service->execute($this->requestService);
    }

}
