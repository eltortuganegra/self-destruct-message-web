<?php

namespace App\domain\Infrastructure\Repositories;

use App\domain\Entities\Secret\Secret;
use App\domain\Entities\Secret\SecretFactory;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactory;
use App\domain\ValueObjects\Message\MessageFactory;
use App\domain\ValueObjects\SecretId\SecretId;
use App\domain\ValueObjects\SecretId\SecretIdFactory;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Ramsey\Uuid\Uuid;

class DoctrineSecretRepository implements SecretRepository
{
    private $entityManager;
    private $secretFactory;
    private $secretIdFactory;
    private $messageFactory;
    private $expirationTimeFactory;

    public function __construct(
        EntityManager $entityManager,
        SecretFactory $secretFactory,
        SecretIdFactory $secretIdFactory,
        MessageFactory $messageFactory,
        ExpirationTimeFactory $expirationTimeFactory
    ) {
        $this->entityManager = $entityManager;
        $this->secretFactory = $secretFactory;
        $this->secretIdFactory = $secretIdFactory;
        $this->messageFactory = $messageFactory;
        $this->expirationTimeFactory = $expirationTimeFactory;
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
        $entity->setMessage($secret->getMessage()->getContent());
        $expiredAt = new DateTime();
        $expiredAt->add(new DateInterval('PT' . $secret->getExpirationTime()->getSeconds() . 'S'));
        $entity->setExpiredAt($expiredAt);
        $entity->setExpirationTime($secret->getExpirationTime()->getSeconds());

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

        $secret = $this->createSecretFromResult($result);

        return $secret;
    }

    private function findSecretBySecretId(SecretId $secretId)
    {
        $result = $this->entityManager->getRepository(\App\Entity\Secret::class)->findOneBy([
            'secretId' => $secretId->getIdentifier()
        ]);

        return $result;
    }

    private function createSecretFromResult($result): Secret
    {
        $secretId = $this->secretIdFactory->create($result->getSecretId());
        $message = $this->messageFactory->create($result->getMessage());
        $expirationTime = $this->expirationTimeFactory->create($result->getExpirationTime());
        $expirationDate = $result->getExpiredAt();
        $secret = $this->secretFactory->createFromRepository($secretId, $message, $expirationTime, $expirationDate);

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