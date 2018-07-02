<?php

namespace App\Controller;

use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Infrastructure\Repositories\DoctrineSecretRepository;
use App\domain\Services\SecretShowAndDestroyService\SecretNotFoundException;
use App\domain\Services\SecretShowAndDestroyService\SecretShowAndDestroyService;
use App\domain\Services\SecretShowAndDestroyService\SecretShowAndDestroyServiceRequest;
use App\domain\ValueObjects\LinkForShare\LinkForShareFactoryImp;
use App\domain\ValueObjects\SecretId\SecretIdFactoryImp;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecretShowController extends Controller
{

    public function index(Request $request, string $secretId)
    {

        $secretIdFactory = new SecretIdFactoryImp();
        $serviceRequest = new SecretShowAndDestroyServiceRequest($secretIdFactory);
        $serviceRequest->setIdentifier($secretId);
        $entityManager = $this->getDoctrine()->getManager();
        $secretFactory = new SecretFactoryImp();
        $secretRepository = new DoctrineSecretRepository($entityManager, $secretFactory, $secretIdFactory);
        $linkForShareFactory = new LinkForShareFactoryImp();

        $protocol = empty($request->server->get('HTTPS'))
            ? 'http'
            : 'https';
        $domain = $request->server->get('HTTP_HOST');

        $serviceRequest->setProtocol($protocol);
        $serviceRequest->setDomain($domain);
        $serviceRequest->setIdentifier($secretId);

        try {

            $service = new SecretShowAndDestroyService($secretRepository, $linkForShareFactory);
            $serviceResponse = $service->execute($serviceRequest);

            return $this->render(
                'secret_show/index.html.twig',
                [
                    'response' => $serviceResponse,
                ],
                new Response('', 200)
            );
        } catch(SecretNotFoundException $e) {
            return $this->render(
                'secret_show/error.html.twig',
                [
                    'controller_name' => 'SecretShowController',
                ],
                new Response('', 404)
            );
        }

    }
}
