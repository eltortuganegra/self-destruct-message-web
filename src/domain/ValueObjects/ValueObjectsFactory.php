<?php

namespace App\domain\ValueObjects;

use App\domain\ValueObjects\SecretId\SecretIdFactory;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;

class ValueObjectsFactory
{
    static function getSecretIdFactory(): SecretIdFactory
    {
        return new SecretIdFactoryImp();
    }

}