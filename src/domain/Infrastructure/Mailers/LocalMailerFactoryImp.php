<?php

namespace App\domain\Infrastructure\Mailers;

use App\domain\ValueObjects\ValueObjectsFactory;

class LocalMailerFactoryImp implements MailerFactory
{

    static public function create(string $from, string $to, string $subject, string $body): Mailer
    {
        $mailFactory = ValueObjectsFactory::getMailFactory();
        $fromEmail = $mailFactory->create($from);
        $toEmail = $mailFactory->create($to);

        return new LocalMailerImp(
            $fromEmail,
            $toEmail,
            $subject,
            $body
        );
    }
}