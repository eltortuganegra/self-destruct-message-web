<?php

namespace App\domain\ValueObjects\Mail;


interface MailFactory
{
    public function create(string $value): Mail;
}