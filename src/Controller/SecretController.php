<?php

namespace App\Controller;

use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Services\SecretCreateService\SecretCreateService;
use App\domain\Services\SecretCreateService\SecretCreateServiceRequest;
use App\domain\Services\ServiceResponse;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdFactory;

use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecretController extends Controller
{

    private $serviceRequest;
    private $service;
    private $serviceResponse;

    public function __construct()
    {
        $this->createSecretCreateServiceRequest();
        $this->createSecretCreateService();
    }

    private function createSecretCreateServiceRequest(): void
    {
        $this->serviceRequest = new SecretCreateServiceRequest();
    }

    private function createSecretCreateService(): void
    {
        $secretFactory = new SecretFactoryImp();
        $linkForShareFactory = new LinkForShareFactoryImp();
        $this->service = new SecretCreateService($secretFactory, $linkForShareFactory);
    }

    public function create(Request $request)
    {
        $this->loadSecretCreateServiceRequest($request);
        $this->executeService();

        return $this->render('secret/created.html.twig', [
            'response' => $this->serviceResponse
        ]);
    }

    private function loadSecretCreateServiceRequest(Request $request): void
    {
        $this->loadNextSecretId();
        $this->loadProtocolFromRequest($request);
        $this->loadDomainFromRequest($request);
        $this->loadMessageFromRequest($request);
    }

    private function executeService()
    {
        $this->serviceResponse = $this->service->execute($this->serviceRequest);
    }

    private function loadNextSecretId(): void
    {
        $secretId = SecretIdFactory::create(Uuid::uuid4());
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
        $this->serviceRequest->setMessage($message);
    }

}