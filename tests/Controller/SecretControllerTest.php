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
        $this->client->request( 'POST', '/secret', [
            'message' => 'hello world',
            'expirationTime' => 600
        ]);

        // Act
        $returnedStatusCode = $this->client->getResponse()->getStatusCode();

        // Assert
        $this->assertEquals(200, $returnedStatusCode);
    }

    public function testWhenUsersCreateASecretTheirMustCanToSeeTheLinkToShareTheSecret()
    {
        // Arrange
        $crawler = $this->client->request( 'POST', '/secret', [
            'message' => 'hello world',
            'expirationTime' => 600
        ]);

        // Act
        $amountLinkForShare = $crawler->filter('.link-for-share')->count();

        // Assert
        $this->assertEquals(1, $amountLinkForShare);
    }

    public function testWhenUsersHaveCreatedTheSecretTheyCanReturnToTheMainPage()
    {
        // Arrange
        $crawler = $this->client->request( 'POST', '/secret', [
            'message' => 'hello world',
            'expirationTime' => 600
        ]);

        // Act
        $amountLinkForCreateANewSecret = $crawler->filter('.link-to-create-secret .button')->count();

        // Assert
        $this->assertEquals(1, $amountLinkForCreateANewSecret);
    }

    public function testWhenSecretsAreCreatedTheirLinksMustBeShown()
    {
        // Arrange
        $crawler = $this->client->request( 'POST', '/secret', [
            'message' => 'hello world',
            'expirationTime' => 600
        ]);
        $url = $crawler->filter('.link-for-share .link .link-field')->attr('value');

        // Act
        $isUrlValid = filter_var($url, FILTER_VALIDATE_URL) != false;

        // Assert
        $this->assertEquals(true, $isUrlValid);
    }

    public function testWhenSecretsAreCreatedTheyMustBeShown()
    {
        // Arrange
        $crawler = $this->client->request( 'POST', '/secret', [
            'message' => 'hello world',
            'expirationTime' => 600
        ]);

        // Act
        $isMessageFound = $crawler->filter('.secret')->count() == 1;

        // Assert
        $this->assertEquals(true, $isMessageFound);
    }

    public function testShouldShow404PageWhenUrlHasNotIdentifierOfSecret()
    {
        // Arrange
        $this->client->request( 'GET', '/secret');

        // Act
        $returnedStatusCode = $this->client->getResponse()->getStatusCode();

        // Assert
        $this->assertEquals(404, $returnedStatusCode);
    }

    public function testShouldShowExpirationDateWhenSecretIsCreated()
    {
        // Arrange
        $crawler = $this->client->request( 'POST', '/secret', [
            'message' => 'hello world',
            'expirationTime' => 600
        ]);

        // Act
        $isMessageFound = $crawler->filter('.expiration-date')->count() == 1;

        // Assert
        $this->assertEquals(true, $isMessageFound);
    }

}
