<?php

namespace App\domain\Infrastructure\Repositories;


use App\domain\ValueObjects\ValueObjectsFactory;
use Doctrine\ORM\EntityManagerInterface;

class RepositoriesFactory
{
    static public function getMemorySecretRepository()
    {
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();

        return new MemorySecretRepository($secretIdFactory);
    }

//    static public function getDoctrineSecretRepository(EntityManagerInterface $entityManager)
//    {
//        SecretFactory $secretFactory,
//        SecretIdFactory $secretIdFactory,
//        MessageFactory $messageFactory,
//        ExpirationTimeFactory $expirationTimeFactory
//
//        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
//
//        return new DoctrineSecretRepository($secretIdFactory);
//    }
}