<?php

namespace App\tests\domain;

use App\domain\ValueObjects\ExpirationTime\ExpirationTime;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdImp;
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
        $secretIdFactory = new SecretIdFactoryImp();
        $this->secretId = $secretIdFactory->create($identifier);
        $messageFactory = new MessageFactoryImp();
        $this->message = $messageFactory->create('This is a secret.');
        $secretFactory = new SecretFactoryImp();
        $expirationTimeFactory = new ExpirationTimeFactoryImp();
        $expirationTime = $expirationTimeFactory->create(new DateTime());
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

}
