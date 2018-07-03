<?php

namespace App\domain\ValueObjects\Message;


interface MessageFactory
{
    public function create(string $message): Message;
}