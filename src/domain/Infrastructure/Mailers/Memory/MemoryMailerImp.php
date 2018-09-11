<?php

namespace App\domain\Infrastructure\Mailers\Memory;

use App\domain\Infrastructure\Mailers\Mailer;
use App\domain\ValueObjects\Mail\Mail;


class MemoryMailerImp implements Mailer
{
    private $from;
    private $to;
    private $subject;
    private $body;
    private $isMailSent;

    public function __construct()
    {
        $this->isMailSent = false;
    }

    public function send(Mail $from, Mail $to, string $subject, string $body): void
    {
        $this->loadAttributes($from, $to, $subject, $body);
    }

    private function loadAttributes(Mail $from, Mail $to, string $subject, string $body): void
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function isMailSent(): bool
    {
        return true;
    }

}