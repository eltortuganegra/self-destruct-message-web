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

}
