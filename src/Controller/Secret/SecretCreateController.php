<?php

namespace App\Controller\Secret;

use App\domain\Infrastructure\Mailers\MailerFactory;
use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\Services\SecretCreateService\ExpirationTimeIsNotFoundException;
use App\domain\Services\SecretCreateService\SecretCreateServiceRequest;
use App\domain\Services\ServicesFactory;
use App\domain\ValueObjects\Message\MessageIsVoidException;
use App\domain\ValueObjects\ValueObjectsFactory;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecretCreateController extends Controller
{
    private $serviceRequest;
    private $service;
    private $serviceResponse;
    private $entityManager;
    private $fromEmail;

    public function __construct($fromEmail)
    {
        $this->fromEmail = $fromEmail;
    }

    public function index(Request $request)
    {
        try {
            $this->executeSecretCreateService($request);

            return $this->renderCreatedSecret();
        } catch(MessageIsVoidException $exception) {

            return $this->renderCodeIsEmpty();
        } catch(ExpirationTimeIsNotFoundException $exception) {

            return $this->renderCodeIsEmpty();
        }
    }

    private function executeSecretCreateService(Request $request): void
    {
        $this->loadEntityManager();
        $this->createSecretCreateServiceRequest();
        $this->createSecretCreateService();
        $this->loadSecretCreateServiceRequest($request);
        $this->executeService();
    }

    private function loadEntityManager(): void
    {
        $this->entityManager = $this->getDoctrine()->getManager();
    }

    private function createSecretCreateServiceRequest(): void
    {
        $this->serviceRequest = new SecretCreateServiceRequest();
    }

    private function createSecretCreateService(): void
    {
        $secretRepository = RepositoriesFactory::getDoctrineSecretRepository($this->entityManager);
        $localMailer = MailerFactory::createLocalMailer();
        $this->service = ServicesFactory::createSecretCreateService($secretRepository, $localMailer);
    }

    private function loadSecretCreateServiceRequest(Request $request): void
    {
        $this->loadNextSecretId();
        $this->loadProtocolFromRequest($request);
        $this->loadDomainFromRequest($request);
        $this->loadMessageFromRequest($request);
        $this->loadExpirationTimeFromRequest($request);
        $this->loadMailFromMail();
        $this->loadMailToFromRequest($request);
    }

    private function executeService()
    {
        $this->serviceResponse = $this->service->execute($this->serviceRequest);
    }

    private function loadNextSecretId(): void
    {
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretId = $secretIdFactory->create(Uuid::uuid4());
        $this->serviceRequest->setSecretId($secretId);
    }

    private function loadProtocolFromRequest(Request $request): void
    {
        $protocol = empty($request->server->get('HTTPS'))
            ? 'http'
            : 'https';
        $this->serviceRequest->setProtocol($protocol);
    }

    private function loadDomainFromRequest(Request $request): void
    {
        $domain = $request->server->get('HTTP_HOST');
        $this->serviceRequest->setDomain($domain);
    }

    private function loadMessageFromRequest($request): void
    {
        $message = $request->request->get('message');
        if (empty($message)) {
            $message = '';
        }
        $this->serviceRequest->setMessage($message);
    }

    private function loadExpirationTimeFromRequest($request): void
    {
        $expirationTime = $request->request->get('expirationTime');
        if (empty($expirationTime)) {
            throw new ExpirationTimeIsNotFoundException();
        }
        $this->serviceRequest->setExpirationTimeInSeconds($expirationTime);
    }

    private function loadMailFromMail()
    {
        $this->serviceRequest->setFromMail($this->fromEmail);
    }

    private function loadMailToFromRequest($request)
    {
        $toMail = $request->request->get('email');
        if ( ! empty($toMail)) {
            $this->serviceRequest->setToMail($toMail);
        }
    }

    private function renderCreatedSecret(): Response
    {
        return $this->render('secret/created.html.twig', [
            'response' => $this->serviceResponse
        ]);
    }

    private function renderCodeIsEmpty(): Response
    {
        return $this->render(
            'secret/error.html.twig',
            [],
            new Response('', 404)
        );
    }



}