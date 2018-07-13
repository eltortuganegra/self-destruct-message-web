<?php

namespace App\domain\Entities;

use App\domain\Entities\Secret\SecretFactory;
use App\domain\Entities\Secret\SecretFactoryImp;

class EntitiesFactory
{
    static public function getSecretFactory(): SecretFactory
    {
        return new SecretFactoryImp();
    }

}