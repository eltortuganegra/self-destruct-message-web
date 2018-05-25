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

    public function testWhenUsersHaveCreatedTheSecretTheyCanReturnToTheMainPage()
    {
        // Arrange
        $crawler = $this->client->request( 'POST', '/secret', ['message' => 'hello world']);

        // Act
        $amountLinkForCreateANewSecret = $crawler->filter('.linkForCreateNewSecret')->count();

        // Assert
        $this->assertEquals(1, $amountLinkForCreateANewSecret);
    }

    public function testWhenSecretsAreCreatedTheirLinksMustBeShown()
    {
        // Arrange
        $crawler = $this->client->request( 'POST', '/secret', ['message' => 'hello world']);
        $url = $crawler->filter('.linkForShare')->attr('value');

        // Act
        $isUrlValid = filter_var($url, FILTER_VALIDATE_URL) != false;

        // Assert
        $this->assertEquals(true, $isUrlValid);
    }

    public function testWhenSecretsAreCreatedTheyMustBeShown()
    {
        // Arrange
        $crawler = $this->client->request( 'POST', '/secret', ['message' => 'hello world']);

        // Act
        $isMessageFound = $crawler->filter('.secret')->count() == 1;

        // Assert
        $this->assertEquals(true, $isMessageFound);
    }

}
