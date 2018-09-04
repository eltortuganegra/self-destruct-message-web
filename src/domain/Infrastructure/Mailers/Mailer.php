<?php

namespace App\domain\Infrastructure\Mailers;

interface Mailer
{
    public function send(): void;
    public function isMailSent(): bool;
}