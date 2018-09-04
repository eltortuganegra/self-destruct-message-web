<?php


use App\domain\Infrastructure\Mailers\MemoryMailerFactoryImp;
use PHPUnit\Framework\TestCase;

class MemoryMailerTest extends TestCase
{
    public function testItShouldSendDefaultEmail() {
        // Arrange
        $from = 'from@eltortuganegra.com';
        $to = 'to@eltortuganegra.com';
        $subject = 'Subject';
        $body = 'This is a test.';
        $mailer = MemoryMailerFactoryImp::create($from, $to, $subject, $body);

        // Act
        $isMailSent = $mailer->send();

        // Assert
        $this->assertTrue($isMailSent, 'Email has not been sent.');
    }

}
