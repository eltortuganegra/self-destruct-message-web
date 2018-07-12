<?php

namespace app\tests\domain\ValueObjects\ExpirationTime;

use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use DateTime;
use PHPUnit\Framework\TestCase;

class ExpirationTimeTest extends TestCase
{
    private $expirationTime;

    public function setUp()
    {
        $expirationTimeSeconds = 10;
        $expirationTimeFactory = new ExpirationTimeFactoryImp();
        $this->expirationTime = $expirationTimeFactory->create($expirationTimeSeconds);
    }

    public function testWhenExpirationTimeIsCreatedItMustReturnHowManySeconds()
    {
        // Act
        $seconds = $this->expirationTime->getSeconds();

        // Assert
        $this->assertEquals(10, $seconds);
    }
}