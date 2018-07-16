<?php

namespace App\Controller;

use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\DoctrineSecretRepository;
use App\domain\Services\SecretShowAndDestroyService\SecretNotFoundException;
use App\domain\Services\SecretShowAndDestroyService\SecretShowAndDestroyService;
use App\domain\Services\SecretShowAndDestroyService\SecretShowAndDestroyServiceRequest;
use App\domain\Services\ServiceResponse;
use App\domain\ValueObjects\ExpirationTime\ExpirationTimeFactoryImp;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactoryImp;
use App\domain\ValueObjects\Message\MessageFactoryImp;
use App\domain\ValueObjects\ValueObjectsFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecretShowController extends Controller
{
    private $service;
    private $serviceRequest;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretFactory = new SecretFactoryImp();
        $messageFactory = new MessageFactoryImp();
        $expirationTimeFactory = new ExpirationTimeFactoryImp();
        $secretRepository = new DoctrineSecretRepository(
            $entityManager,
            $secretFactory,
            $secretIdFactory,
            $messageFactory,
            $expirationTimeFactory
        );
        $this->serviceRequest = new SecretShowAndDestroyServiceRequest($secretIdFactory);
        $linkForShareFactory = ValueObjectsFactory::getLinkForShareFactory();
        $this->service = new SecretShowAndDestroyService($secretRepository, $linkForShareFactory);
    }

    public function index(Request $request, string $secretId)
    {
        $this->loadServiceRequest($request, $secretId);
        try {
            $serviceResponse = $this->executeService();

            return $this->renderSecret($serviceResponse);
        } catch(SecretNotFoundException $e) {

            return $this->renderSecretNotFound();
        }
    }

    private function loadServiceRequest(Request $request, string $secretId): void
    {
        $protocol = empty($request->server->get('HTTPS'))
            ? 'http'
            : 'https';
        $this->serviceRequest->setProtocol($protocol);

        $domain = $request->server->get('HTTP_HOST');
        $this->serviceRequest->setDomain($domain);

        if (empty($secretId)) {
            $secretId = '';
        }
        $this->serviceRequest->setIdentifier($secretId);
    }

    private function executeService(): ServiceResponse
    {
        $serviceResponse = $this->service->execute($this->serviceRequest);

        return $serviceResponse;
    }

    private function renderSecret($serviceResponse): Response
    {
        return $this->render(
            'secret_show/index.html.twig',
            [
                'response' => $serviceResponse,
            ],
            new Response('', 200)
        );
    }

    private function renderSecretNotFound(): Response
    {
        return $this->render(
            'secret_show/error.html.twig',
            [
                'controller_name' => 'SecretShowController',
            ],
            new Response('', 404)
        );
    }
}
