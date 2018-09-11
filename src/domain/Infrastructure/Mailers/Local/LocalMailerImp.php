<?php

namespace App\domain\Infrastructure\Mailers\Local;

use App\domain\Infrastructure\Mailers\Mailer;
use App\domain\ValueObjects\Mail\Mail;


class LocalMailerImp implements Mailer
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
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=UTF-8' . "\r\n" .
            'From: ' . $this->from->getValue() . "\r\n" .
            'Reply-To: ' . $this->to->getValue() . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    }

    /**
     * @param Mail $from
     * @param Mail $to
     * @param string $subject
     * @param string $body
     */
    private function loadAttributes(Mail $from, Mail $to, string $subject, string $body): void
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->isMailSent = false;
    }
}