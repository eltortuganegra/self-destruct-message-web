<?php

namespace App\tests\Controller;


use App\domain\Entities\EntitiesFactory;
use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecretConfirmUnveilTheSecretControllerTest extends WebTestCase
{
    private $client;
    private $secretRepository;
    private $secret;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testWhenUsersUseTheLinkToShareTheyMustSeeTheUnveilButton()
    {
        // Arrange
        $this->createDefaultSecret();
        $this->addSecretToRepository();
        $crawler = $this->client->request( 'GET', '/secret/' . $this->secret->getSecretId()->getIdentifier());

        // Act
        $isThereConfirmationButton = $crawler->filter('.confirmation-unveil-secret .button')->count();

        // Assert
        $this->assertEquals(1, $isThereConfirmationButton);
    }

    private function createDefaultSecret(): void
    {
        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->secretRepository = RepositoriesFactory::getDoctrineSecretRepository($em);
        $secretFactory = EntitiesFactory::getSecretFactory();
        $secretId = $this->secretRepository->nextIdentity();
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $message = $messageFactory->create('This is a valid message for test: testWhenUsersUseTheLinkToShareTheyMustSeeTheUnveilButton');
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();
        $expirationTime = $expirationTimeFactory->create(86600);
        $this->secret = $secretFactory->create($secretId, $message, $expirationTime);
    }

    private function addSecretToRepository(): void
    {
        $this->secretRepository->add($this->secret);
    }

}