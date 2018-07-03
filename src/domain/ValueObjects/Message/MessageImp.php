<?php

namespace App\domain\ValueObjects\Message;


class MessageImp implements Message
{
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getContent(): string
    {
        return $this->message;
    }
}