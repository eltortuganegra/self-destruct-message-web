<?php

namespace app\tests\domain\ValueObjects\ExpirationTime;

use App\domain\ValueObjects\ExpirationTime\ExpirationTimeImp;
use App\domain\ValueObjects\ExpirationTime\StubExpirationTimeImp;
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

    public function testWhenExpirationTimeObjectIsCreatedItMustCanReturnCurrentDate()
    {
        // Arrange
        $theSecretOfMonkeyIslandReleaseDate = '1990-10-15';
        $currentDate = new DateTime($theSecretOfMonkeyIslandReleaseDate);
        $expirationTime = new StubExpirationTimeImp();

        // Act
        $date = $expirationTime->getDate();

        // Arrange
        $this->assertEquals($currentDate, $date);
    }
}