<?php

namespace App\tests\domain;


use App\domain\Entities\Secret\Secret;
use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
use App\domain\ValueObjects\ValueObjectsFactory;
use DateTime;
use PHPUnit\Framework\TestCase;

class SecretFactoryTest extends TestCase
{
    public function testFactoryMustReturnSecret()
    {
        // Arrange
        $identifier = '1234';
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretId = $secretIdFactory->create($identifier);
        $messageText = 'This is a message.';
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $message = $messageFactory->create($messageText);
        $secretFactory = new SecretFactoryImp();
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();
        $expirationTimeInSeconds = 120;
        $expirationTime = $expirationTimeFactory->create($expirationTimeInSeconds);
        $secret = $secretFactory->create($secretId, $message, $expirationTime);

        // Act
        $isReturnedInstanceASecret = $secret instanceof Secret;

        // Assert
        $this->assertEquals(true, $isReturnedInstanceASecret);
    }

}