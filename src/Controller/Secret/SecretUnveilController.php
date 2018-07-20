<?php

namespace App\Controller\Secret;

use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\Services\SecretUnveilService\ExpirationTimeIsExpiredException;
use App\domain\Services\SecretUnveilService\SecretNotFoundException;
use App\domain\Services\SecretUnveilService\SecretUnveilServiceRequest;
use App\domain\Services\ServiceResponse;
use App\domain\Services\ServicesFactory;
use App\domain\ValueObjects\ValueObjectsFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecretUnveilController extends Controller
{
    private $service;
    private $serviceRequest;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretRepository = RepositoriesFactory::getDoctrineSecretRepository($entityManager);
        $this->serviceRequest = new SecretUnveilServiceRequest($secretIdFactory);
        $this->service = ServicesFactory::createSecretUnveilService($secretRepository);
    }

    public function index(Request $request, string $secretId)
    {
        $this->loadServiceRequest($request, $secretId);
        try {
            $serviceResponse = $this->executeService();

            return $this->renderSecret($serviceResponse);
        } catch(SecretNotFoundException $e) {

            return $this->renderSecretNotFound();
        } catch(ExpirationTimeIsExpiredException $e) {

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
                'controller_name' => 'SecretUnveilController',
            ],
            new Response('', 404)
        );
    }
}
