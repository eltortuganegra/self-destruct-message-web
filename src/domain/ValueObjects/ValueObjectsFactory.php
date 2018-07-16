<?php

namespace App\domain\ValueObjects;

use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactory;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactory;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactoryImp;
use App\domain\ValueObjects\Message\MessageFactory;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdFactory;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;

class ValueObjectsFactory
{
    static function getSecretIdFactory(): SecretIdFactory
    {
        return new SecretIdFactoryImp();
    }

    static function getLinkForShareFactory(): LinkForShareFactory
    {
        return new LinkForShareFactoryImp();
    }

    static function getMessageFactory(): MessageFactory
    {
        return new MessageFactoryImp();
    }

    static function getExpirationTimeFactory(): ExpirationTimeFactory
    {
        return new ExpirationTimeFactoryImp();
    }

}