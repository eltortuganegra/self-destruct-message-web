<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecretShowControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testIfErrorPageIsShowedWhenSecretIdDoesNotExist()
    {
        // Arrange
        $this->client->request( 'GET', '/secret/noexist');

        // Act
        $returnedStatusCode = $this->client->getResponse()->getStatusCode();

        // Assert
        $this->assertEquals(404, $returnedStatusCode);
    }

    public function testIfSecretShowContentErrorPageIsShowedWhenSecretIdDoesNotExist()
    {
        // Arrange
        $crawler = $this->client->request( 'GET', '/secret/noexist');

        // Act
        $amountSecretShowDiv = $crawler->filter('.secret_show.error')->count();

        // Assert
        $this->assertEquals(1, $amountSecretShowDiv);
    }

    public function testShouldShowSecretWhenSecretExists()
    {
        // Arrange
        $crawler = $this->client->request( 'POST', '/secret', ['message' => 'hello world']);
        $linkForShareUrl = $crawler->filter('.link-for-share .link .link-field')->first()->attr('value');

        $crawler = $this->client->request('GET', $linkForShareUrl);

        // Act
        $amountSecretShowDiv = $crawler->filter('.secret')->count();

        // Assert
        $this->assertEquals(1, $amountSecretShowDiv);
    }

}