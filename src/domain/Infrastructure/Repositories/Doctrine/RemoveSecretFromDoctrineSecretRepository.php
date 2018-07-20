<?php

namespace App\domain\Infrastructure\Repositories\Doctrine;


use App\domain\Entities\Secret\Secret;
use Doctrine\ORM\EntityManager;

class RemoveSecretFromDoctrineSecretRepository
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(Secret $secret): void
    {
        $secretEntity = $this->entityManager->getRepository(\App\Entity\Secret::class)->findOneBy([
            'secretId' => $secret->getSecretId()->getIdentifier()
        ]);
        $this->entityManager->remove($secretEntity);
        $this->entityManager->flush();
    }

}