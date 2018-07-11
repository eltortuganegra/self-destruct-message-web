<?php

namespace app\tests\domain\ValueObjects\ExpirationTime;

use App\domain\ValueObjects\ExpirationTime\ExpirationTimeImp;
use DateTime;
use PHPUnit\Framework\TestCase;

class ExpirationTimeTest extends TestCase
{

    public function testWhenExpirationTimeObjectIsCreatedMustCanReturnExpiration()
    {
        // Arrange
        $expirationTime = new ExpirationTimeImp();
        $date = $expirationTime->getDate();

        // Act
        $isDateTimeObject = $date instanceof DateTime;


        // Arrange
        $this->assertEquals(true, $isDateTimeObject);

    }
}