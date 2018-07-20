<?php

namespace App\tests\Controller;

use App\domain\Entities\EntitiesFactory;
use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExpiredSecretSecretUnveilControllerTest extends WebTestCase
{
    private $client;
    private $secret;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testShouldShow404PageWhenSecretIsExpired()
    {
        // Arrange
        $this->addExpiredSecretToRepository();
        $this->client->request( 'GET', '/secret/' . $this->secret->getSecretId()->getIdentifier());

        // Act
        $returnedStatusCode = $this->client->getResponse()->getStatusCode();

        // Assert
        $this->assertEquals(404, $returnedStatusCode);
    }

    private function addExpiredSecretToRepository(): void
    {
        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $secretRepository = RepositoriesFactory::getDoctrineSecretRepository($em);
        $secretFactory = EntitiesFactory::getSecretFactory();
        $secretId = $secretRepository->nextIdentity();
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $message = $messageFactory->create('This is a valid message');
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();
        $expirationTime = $expirationTimeFactory->create(120);
        $expiredExpirationDate = new DateTime('1990-10-15');
        $this->secret = $secretFactory->createFromRepository($secretId, $message, $expirationTime, $expiredExpirationDate);
        $secretRepository->add($this->secret);
    }

}