<?php

namespace App\domain\Infrastructure\Repositories\Doctrine;


use App\domain\Entities\Secret\Secret;
use App\domain\Entities\Secret\SecretFactory;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactory;
use App\domain\ValueObjects\Message\MessageFactory;
use App\domain\ValueObjects\SecretId\SecretId;
use App\domain\ValueObjects\SecretId\SecretIdFactory;
use Doctrine\ORM\EntityManager;

class FindSecretFromDoctrineSecretRepository
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
        ExpirationTimeFactory $expirationTimeFactory)
    {
        $this->entityManager = $entityManager;
        $this->secretFactory = $secretFactory;
        $this->secretIdFactory = $secretIdFactory;
        $this->messageFactory = $messageFactory;
        $this->expirationTimeFactory = $expirationTimeFactory;
    }

    public function execute(SecretId $secretId): ?Secret
    {
        $result = $this->entityManager->getRepository(\App\Entity\Secret::class)->findOneBy([
            'secretId' => $secretId->getIdentifier()
        ]);

        if (empty($result)) {
            return null;
        }

        $secretId = $this->secretIdFactory->create($result->getSecretId());
        $message = $this->messageFactory->create($result->getMessage());
        $expirationTime = $this->expirationTimeFactory->create($result->getExpirationTime());
        $expirationDate = $result->getExpiredAt();
        $secret = $this->secretFactory->createFromRepository($secretId, $message, $expirationTime, $expirationDate);

        return $secret;
    }

}