<?php

namespace App\domain\Infrastructure\Mailers;

use App\domain\ValueObjects\Mail\Mail;


class MemoryMailerImp implements Mailer
{

    private $from;
    private $to;
    private $subject;
    private $body;

    public function __construct(Mail $from, Mail $to, string $subject, string $body)
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function send(): bool
    {
        return true;
    }
}