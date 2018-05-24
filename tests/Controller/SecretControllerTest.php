<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecretControllerTest  extends WebTestCase
{
    private $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testPostRequestMustReturnA200HttpCodeWhenMethodIsPost()
    {
        // Arrange
        $this->client->request( 'POST', '/secret', ['message' => 'hello world']);

        // Act
        $returnedStatusCode = $this->client->getResponse()->getStatusCode();

        // Assert
        $this->assertEquals(200, $returnedStatusCode);
    }

    public function testWhenUsersCreateASecretTheirMustCanToSeeTheLinkToShareTheSecret()
    {
        // Arrange
        $crawler = $this->client->request( 'POST', '/secret', ['message' => 'hello world']);

        // Act
        $amountLinkForShare = $crawler->filter('.linkForShare')->count();

        // Assert
        $this->assertEquals(1, $amountLinkForShare);
    }

}
