<?php

use App\domain\ValueObjects\SecretId\SecretId;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;

use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;

class SecretIdTest extends TestCase
{
    public function testCheckSecretId()
    {
        // Arrange
        $identifier = '1234';
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretId = $secretIdFactory->create($identifier);

        // Act
        $isInstanceOfSecretId = $secretId instanceof SecretId;

        // Assert
        $this->assertEquals(true, $isInstanceOfSecretId);
    }

}
