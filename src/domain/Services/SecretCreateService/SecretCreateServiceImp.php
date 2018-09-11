<?php

namespace App\domain\Services\SecretCreateService;


use App\domain\Entities\Secret\SecretFactory;
use App\domain\Infrastructure\Mailers\Mailer;
use App\domain\Infrastructure\Repositories\SecretRepository;
use App\domain\Notifications\Email\SomebodyHasSharedASecretWithYouEmailNotification;
use App\domain\Services\Service;
use App\domain\Services\ServiceRequest;
use App\domain\Services\ServiceResponse;
use App\domain\ValueObjects\LinkForShare\LinkForShare;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactory;
use App\domain\ValueObjects\ValueObjectsFactory;


class SecretCreateServiceImp implements Service, SecretCreateService
{
    private $secretFactory;
    private $linkForShareFactory;
    private $secretRepository;
    private $secret;
    private $serviceRequest;
    private $mailer;

    public function __construct(
        SecretFactory $secretFactory,
        LinkForShareFactory $linkForShareFactory,
        SecretRepository $secretRepository,
        Mailer $mailer)
    {
        $this->secretFactory = $secretFactory;
        $this->linkForShareFactory = $linkForShareFactory;
        $this->secretRepository = $secretRepository;
        $this->mailer = $mailer;
    }

    public function execute(ServiceRequest $serviceRequest): ServiceResponse
    {

        $this->loadServiceRequest($serviceRequest);
        $this->createSecretFromServiceRequest();
        $this->persistSecret();
        $response = $this->buildResponse();
        if ($this->doesUserWantSendByEmailTheSharedLink()) {
            $this->sendByEmailTheSharedLink($response->getLinkForShare());
        }

        return $response;
    }

    private function createSecretFromServiceRequest()
    {
        $secretId = $this->secretRepository->nextIdentity();

        $this->secret = $this->secretFactory->create(
            $secretId,
            $this->serviceRequest->getMessage(),
            $this->serviceRequest->getExpirationTime()
        );
    }

    private function persistSecret(): void
    {
        $this->secretRepository->add($this->secret);
    }

    private function buildResponse(): SecretCreateServiceResponse
    {
        $secret = $this->secretRepository->findBySecretId($this->secret->getSecretId());
        $linkForShare = $this->linkForShareFactory->create(
            $this->serviceRequest->getProtocol(),
            $this->serviceRequest->getDomain(),
            $this->secret->getSecretId()->getIdentifier()
        );

        $response = new SecretCreateServiceResponse($secret, $linkForShare, $this->mailer->isMailSent());

        return $response;
    }

    private function loadServiceRequest(ServiceRequest $serviceRequest): void
    {
        $this->serviceRequest = $serviceRequest;
    }

    private function doesUserWantSendByEmailTheSharedLink(): bool
    {
        return ! empty($this->serviceRequest->getToMail());
    }

    private function sendByEmailTheSharedLink(LinkForShare $linkForShare): void
    {
        $mailFactory = ValueObjectsFactory::getMailFactory();
        $fromMail = $mailFactory->create('no-reply@eltortuganegra.com');
        $toMail = $mailFactory->create($this->serviceRequest->getToMail());
        $somebodyHasSharedASecretWithYouEmailNotification = new SomebodyHasSharedASecretWithYouEmailNotification($linkForShare);
        $subject = $somebodyHasSharedASecretWithYouEmailNotification->getSubject();
        $body = $somebodyHasSharedASecretWithYouEmailNotification->getBody();

        $this->mailer->send($fromMail, $toMail, $subject, $body);
    }
}