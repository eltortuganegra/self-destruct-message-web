<?php

namespace App\domain\Infrastructure\Repositories\Doctrine;


use App\domain\Entities\Secret\Secret;
use Doctrine\ORM\EntityManager;

class AddSecretToDoctrineSecretRepository
{
    private $entityManager;
    private $entity;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(Secret $secret): void
    {
        $this->builtDoctrineEntity($secret);
        $this->persistEntity();
    }

    private function builtDoctrineEntity(Secret $secret): void
    {
        $this->entity = DoctrineSecretEntityFactory::create($secret);
    }

    private function persistEntity(): void
    {
        $this->entityManager->persist($this->entity);
        $this->entityManager->flush();
    }

}