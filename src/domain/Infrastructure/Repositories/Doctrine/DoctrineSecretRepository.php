<?php

namespace App\domain\Infrastructure\Repositories\Doctrine;

use App\domain\Entities\Secret\Secret;
use App\domain\Entities\Secret\SecretFactory;
use App\domain\Infrastructure\Repositories\SecretRepository;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactory;
use App\domain\ValueObjects\Message\MessageFactory;
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
        $addSecretToDoctrineSecretRepository = new AddSecretToDoctrineSecretRepository($this->entityManager);
        $addSecretToDoctrineSecretRepository->execute($secret);
    }

    public function findBySecretId(SecretId $secretId): ?Secret
    {
        $findSecretFromDoctrineSecretRepository = new FindSecretFromDoctrineSecretRepository(
            $this->entityManager,
            $this->secretFactory,
            $this->secretIdFactory,
            $this->messageFactory,
            $this->expirationTimeFactory
        );
        $secret = $findSecretFromDoctrineSecretRepository->execute($secretId);

        return $secret;
    }

    public function remove(Secret $secret): void
    {
        $removeSecretFromDoctrineSecretRepository = new RemoveSecretFromDoctrineSecretRepository($this->entityManager);
        $removeSecretFromDoctrineSecretRepository->execute($secret);
    }

    public function nextIdentity(): SecretId
    {
        $identifier = Uuid::uuid4();
        $secretId = $this->secretIdFactory->create($identifier);

        return $secretId;
    }
}