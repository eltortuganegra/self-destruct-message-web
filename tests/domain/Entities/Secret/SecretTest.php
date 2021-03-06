<?php

namespace App\tests\domain;

use App\domain\Entities\EntitiesFactory;
use App\domain\ValueObjects\ExpirationTime\ExpirationTime;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\ValueObjectsFactory;
use DateTime;
use PHPUnit\Framework\TestCase;
use App\domain\Entities\Secret\SecretFactoryImp;

class SecretTest extends TestCase
{
    private $secretId;
    private $message;
    private $secret;

    public function setUp()
    {
        $identifier = '1234';
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $this->secretId = $secretIdFactory->create($identifier);
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $this->message = $messageFactory->create('This is a secret.');
        $secretFactory = EntitiesFactory::getSecretFactory();
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();
        $expirationTimeInSeconds = 120;
        $expirationTime = $expirationTimeFactory->create($expirationTimeInSeconds);
        $this->secret = $secretFactory->create($this->secretId, $this->message, $expirationTime);
    }

    public function testGetIdentifier()
    {
        // Act
        $secretId = $this->secret->getSecretId();

        // Arrange
        $this->assertEquals($this->secretId, $secretId);
    }

    public function testGetMessage()
    {
        // Act
        $message = $this->secret->getMessage();

        // Arrange
        $this->assertEquals($this->message, $message);
    }

    public function testGetExpirationTime()
    {
        // Arrange
        $expirationTime = $this->secret->getExpirationTime();

        // Act
        $isExpirationTime = $expirationTime instanceof ExpirationTime;


        // Arrange
        $this->assertEquals(true, $isExpirationTime);
    }

    public function testGetExpirationDate()
    {
        // Arrange
        $expirationDate = $this->secret->getExpirationDate();

        // Act
        $isExpirationDateADateTime = $expirationDate instanceof DateTime;


        // Arrange
        $this->assertEquals(true, $isExpirationDateADateTime);
    }

}
