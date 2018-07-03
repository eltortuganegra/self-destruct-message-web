<?php

namespace App\domain\ValueObjects\Message;


interface Message
{
    public function getContent(): string;
}