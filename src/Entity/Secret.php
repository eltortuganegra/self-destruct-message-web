<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SecretRepository")
 */
class Secret
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secretId;

    /**
     * @ORM\Column(type="text")
     */
    private $message;


    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $expirationTime;

    public function getId()
    {
        return $this->id;
    }

    public function getSecretId(): ?string
    {
        return $this->secretId;
    }

    public function setSecretId(string $secretId): self
    {
        $this->secretId = $secretId;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getExpirationTime()
    {
        return $this->expirationTime;
    }

    public function setExpirationTime($expirationTime): void
    {
        $this->expirationTime = $expirationTime;
    }
}
