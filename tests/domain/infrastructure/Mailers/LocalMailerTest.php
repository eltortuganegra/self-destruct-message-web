<?php


use App\domain\Infrastructure\Mailers\LocalMailerFactoryImp;
use PHPUnit\Framework\TestCase;

class LocalMailerTest extends TestCase
{
    public function testItShouldSendMailToDefaultAtEltortuganegraDotCom()
    {
        // Arrange
        $from = 'from@eltortuganegra.com';
        $to = 'default@eltortuganegra.com';
        $subject = 'This is a mail test';
        $body = 'This is the body of the email test.';
        $mailer = LocalMailerFactoryImp::create($from, $to, $subject, $body);
        $mailer->send();

        // Act
        $isMailSent = $mailer->isMailSent();

        // Assert
        $this->assertTrue($isMailSent, 'Mail has not been sent.');
    }

}
