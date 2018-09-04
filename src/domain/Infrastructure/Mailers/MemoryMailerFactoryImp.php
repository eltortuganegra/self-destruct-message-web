<?php

namespace App\domain\Infrastructure\Mailers;

use App\domain\ValueObjects\ValueObjectsFactory;

class MemoryMailerFactoryImp implements MailerFactory
{

    static public function create(string $from, string $to, string $subject, string $body): Mailer
    {
        $mailFactory = ValueObjectsFactory::getMailFactory();
        $fromEmail = $mailFactory->create('asdf');
        $toEmail = $mailFactory->create('fdas');

        return new MemoryMailerImp(
            $fromEmail,
            $toEmail,
            $subject,
            $body
        );
    }
}