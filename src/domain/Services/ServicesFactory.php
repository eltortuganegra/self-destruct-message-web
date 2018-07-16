<?php

namespace App\domain\Services;


use App\domain\Entities\EntitiesFactory;
use App\domain\Infrastructure\Repositories\SecretRepository;
use App\domain\Services\SecretCreateService\SecretCreateServiceImp;
use App\domain\Services\SecretDeleteService\SecretDeleteServiceImp;
use App\domain\Services\SecretShowAndDestroyService\SecretUnveilServiceImp;
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

    static public function createSecretUnveilService(SecretRepository $secretRepository): Service
    {
        $linkForShareFactory = ValueObjectsFactory::getLinkForShareFactory();
        $service = new SecretUnveilServiceImp($secretRepository, $linkForShareFactory, $secretRepository);

        return $service;
    }


}