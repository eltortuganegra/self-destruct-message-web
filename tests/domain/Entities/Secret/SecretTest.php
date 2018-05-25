<?php

namespace App\tests\domain;

use App\domain\ValueObjects\Secret\SecretIdImp;
use PHPUnit\Framework\TestCase;
use App\domain\Entities\Secret\SecretFactoryImp;

class SecretTest extends TestCase
{
    private $secretId;
    private $message;
    private $secret;

    public function setUp()
    {
        $this->secretId = SecretIdImp::create('12345');
        $this->message = 'This is a secret.';
        $this->secret = SecretFactoryImp::create($this->secretId, $this->message);
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
