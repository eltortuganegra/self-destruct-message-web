<?php

namespace App\domain\Infrastructure\Repositories;


use App\domain\Entities\EntitiesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use Doctrine\ORM\EntityManagerInterface;

class RepositoriesFactory
{
    static public function getMemorySecretRepository()
    {
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();

        return new MemorySecretRepository($secretIdFactory);
    }

    static public function getDoctrineSecretRepository(EntityManagerInterface $entityManager)
    {
        $secretFactory = EntitiesFactory::getSecretFactory();
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $messageFactory = ValueObjectsFactory::getMessageFactory();
        $expirationTimeFactory = ValueObjectsFactory::getExpirationTimeFactory();

        return new DoctrineSecretRepository(
            $entityManager,
            $secretFactory,
            $secretIdFactory,
            $messageFactory,
            $expirationTimeFactory

        );
    }
}