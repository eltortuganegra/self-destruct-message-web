<?php

namespace App\domain\ValueObjects\Mail;


class MailImp implements Mail
{
    private $value;

    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    private function setValue(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

}