<?php

namespace App\tests\domain;


use App\domain\Entities\Secret\Secret;
use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
use DateTime;
use PHPUnit\Framework\TestCase;

class SecretFactoryTest extends TestCase
{
    public function testFactoryMustReturnSecret()
    {
        // Arrange
        $identifier = '1234';
        $secretIdFactory = new SecretIdFactoryImp();
        $secretId = $secretIdFactory->create($identifier);
        $messageText = 'This is a message.';
        $messageFactory = new MessageFactoryImp();
        $message = $messageFactory->create($messageText);
        $secretFactory = new SecretFactoryImp();
        $expirationTimeFactory = new ExpirationTimeFactoryImp();
        $expirationTime = $expirationTimeFactory->create(new DateTime());
        $secret = $secretFactory->create($secretId, $message, $expirationTime);

        // Act
        $isReturnedInstanceASecret = $secret instanceof Secret;

        // Assert
        $this->assertEquals(true, $isReturnedInstanceASecret);
    }

}