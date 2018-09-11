<?php

namespace App\domain\Infrastructure\Mailers;


use App\domain\Infrastructure\Mailers\Local\LocalMailerImp;
use App\domain\Infrastructure\Mailers\Memory\MemoryMailerImp;

class MailerFactory
{
    static public function createMemoryMailer(): Mailer
    {
        return new MemoryMailerImp();
    }

    static public function createLocalMailer(): Mailer
    {
        return new LocalMailerImp();
    }
}