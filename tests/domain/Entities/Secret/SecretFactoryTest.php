<?php

namespace App\tests\domain;


use App\domain\Entities\Secret\Secret;
use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
use PHPUnit\Framework\TestCase;

class SecretFactoryTest extends TestCase
{
    public function testFactoryMustReturnSecret()
    {
        // Arrange
        $identifier = '1234';
        $secretIdFactory = new SecretIdFactoryImp();
        $secretId = $secretIdFactory->create($identifier);
        $message = 'This is a message.';
        $secretFactory = new SecretFactoryImp();
        $secret = $secretFactory->create($secretId, $message);

        // Act
        $isReturnedInstanceASecret = $secret instanceof Secret;

        // Assert
        $this->assertEquals(true, $isReturnedInstanceASecret);
    }

}