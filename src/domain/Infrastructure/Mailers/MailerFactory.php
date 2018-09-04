<?php

namespace App\domain\Infrastructure\Mailers;


interface MailerFactory
{
    static public function create(string $from, string $to, string $subject, string $body): Mailer;

}