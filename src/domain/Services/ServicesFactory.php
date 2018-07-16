<?php

namespace App\domain\Services;


use App\domain\Entities\EntitiesFactory;
use App\domain\Infrastructure\Repositories\SecretRepository;
use App\domain\Services\SecretCreateService\SecretCreateServiceImp;
use App\domain\Services\SecretDeleteService\SecretDeleteServiceImp;
use App\domain\Services\SecretShowAndDestroyService\SecretShowAndDestroyServiceImp;
use App\domain\ValueObjects\ValueObjectsFactory;

class ServicesFactory
{
    static public function createSecretDeleteService(SecretRepository $secretRepository): Service
    {
        $service = new SecretDeleteServiceImp($secretRepository);

        return $service;
    }

    static public function createSecretCreateService(SecretRepository $secretRepository): Service
    {
        $secretFactory = EntitiesFactory::getSecretFactory();
        $linkForShareFactory = ValueObjectsFactory::getLinkForShareFactory();
        $service = new SecretCreateServiceImp($secretFactory, $linkForShareFactory, $secretRepository);

        return $service;
    }

    static public function createSecretShowAndDestroyService(SecretRepository $secretRepository): Service
    {
        $linkForShareFactory = ValueObjectsFactory::getLinkForShareFactory();
        $service = new SecretShowAndDestroyServiceImp($secretRepository, $linkForShareFactory, $secretRepository);

        return $service;
    }


}