<?php

namespace App\domain\Infrastructure\Mailers;

use App\domain\ValueObjects\Mail\Mail;


class LocalMailerImp implements Mailer
{
    private $from;
    private $to;
    private $subject;
    private $body;
    private $isMailSent;

    public function __construct(Mail $from, Mail $to, string $subject, string $body)
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->isMailSent = false;
    }

    public function send(): void
    {
        if ($this->sendMail()) {
            $this->setEmailLikeSent();
        }
    }

    public function isMailSent(): bool
    {
        return $this->isMailSent;
    }

    private function sendMail(): bool
    {
        return \mail(
            $this->to->getValue(),
            $this->subject,
            $this->body,
            $this->getHeaders()

        );
    }

    private function setEmailLikeSent(): void
    {
        $this->isMailSent = true;
    }

    private function getHeaders(): string
    {
        return
            'From: ' . $this->from->getValue() . "\r\n" .
            'Reply-To: ' . $this->to->getValue() . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    }
}