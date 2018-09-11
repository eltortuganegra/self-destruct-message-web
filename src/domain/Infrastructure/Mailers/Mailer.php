<?php

namespace App\domain\Infrastructure\Mailers;

use App\domain\ValueObjects\Mail\Mail;

interface Mailer
{
    public function send(Mail $from, Mail $to, string $subject, string $body): void;
    public function isMailSent(): bool;
}