<?php

use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;


class MailTest extends TestCase
{
    public function testItShouldReturnDefaultEmail()
    {
        // Arrange
        $defaultEmail = 'default@eltortuganegra.com';
        $mailFactory = ValueObjectsFactory::getMailFactory();
        $mail = $mailFactory->create($defaultEmail);

        // Act
        $returnedMail = $mail->getValue();

        // Assert
        $this->assertEquals('default@eltortuganegra.com', $returnedMail, 'Mail not match.');
    }
}
