<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest  extends WebTestCase
{
    public function testMainPageMustReturn200HttpCode()
    {
        // Arrange
        $client = static::createClient();
        $client->request('GET', '/');

        // Act
        $returnedStatusCode = $client->getResponse()->getStatusCode();

        // Assert
        $this->assertEquals(200, $returnedStatusCode);
    }

}
