<?php

namespace App\domain\Infrastructure\Repositories;

use App\domain\Entities\Secret\Secret;
use App\domain\Entities\Secret\SecretFactory;
use App\domain\ValueObjects\SecretId\SecretId;
use App\domain\ValueObjects\SecretId\SecretIdFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Ramsey\Uuid\Uuid;

class DoctrineSecretRepository implements SecretRepository
{
    private $entityManager;
    private $secretFactory;
    private $secretIdFactory;

    public function __construct(EntityManager $entityManager, SecretFactory $secretFactory, SecretIdFactory $secretIdFactory)
    {
        $this->entityManager = $entityManager;
        $this->secretFactory = $secretFactory;
        $this->secretIdFactory = $secretIdFactory;
    }

    public function add(Secret $secret): void
    {
        $entity = $this->createEntity($secret);
        $this->persistEntity($entity);
    }

    private function createEntity(Secret $secret): \App\Entity\Secret
    {
        $entity = new \App\Entity\Secret();
        $entity->setSecretId($secret->getSecretId()->getIdentifier());
        $entity->setMessage($secret->getMessage());

        return $entity;
    }

    private function persistEntity($entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findBySecretId(SecretId $secretId): ?Secret
    {
        $result = $this->findSecretBySecretId($secretId);
        if (empty($result)) {
            return null;
        }

        $secret = $this->createSecretFromResult($secretId, $result);

        return $secret;
    }

    private function findSecretBySecretId(SecretId $secretId)
    {
        $result = $this->entityManager->getRepository(\App\Entity\Secret::class)->findOneBy([
            'secretId' => $secretId->getIdentifier()
        ]);

        return $result;
    }

    private function createSecretFromResult(SecretId $secretId, $result): Secret
    {
        $secretId = $this->secretIdFactory->create($result->getSecretId());
        $message = $result->getMessage();
        $secret = $this->secretFactory->create($secretId, $message);

        return $secret;
    }

    public function remove(Secret $secret): void
    {
        $entity = $this->findSecretBySecretId($secret->getSecretId());
        $this->removeEntity($entity);
    }

    private function removeEntity(\App\Entity\Secret $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function nextIdentity(): SecretId
    {
        $identifier = Uuid::uuid4();
        $secretId = $this->secretIdFactory->create($identifier);

        return $secretId;
    }
}