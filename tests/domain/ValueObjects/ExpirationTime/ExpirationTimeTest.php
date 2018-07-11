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
        $theSecretOfMonkeyIslandReleaseDate = '1990-10-15';
        $currentDate = new DateTime($theSecretOfMonkeyIslandReleaseDate);
        $expirationTimeFactory = new ExpirationTimeFactoryImp();
        $this->expirationTime = $expirationTimeFactory->create($currentDate);
    }

    public function testWhenExpirationTimeObjectIsCreatedMustCanReturnExpiration()
    {
        // Arrange
        $date = $this->expirationTime->getDate();

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

        // Act
        $date = $this->expirationTime->getDate();

        // Arrange
        $this->assertEquals($currentDate, $date);
    }
}