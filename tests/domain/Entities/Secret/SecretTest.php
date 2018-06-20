<?php

namespace App\tests\domain;

use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdImp;
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
        $this->secretId = SecretIdFactoryImp::create($identifier);
        $this->message = 'This is a secret.';
        $secretFactory = new SecretFactoryImp();
        $this->secret = $secretFactory->create($this->secretId, $this->message);
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

}
