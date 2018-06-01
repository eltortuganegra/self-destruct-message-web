<?php

namespace App\Controller;

use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\Services\SecretCreateService\SecretCreateService;
use App\domain\Services\SecretCreateService\SecretCreateServiceRequest;
use App\domain\ValueObjects\SecretId\SecretIdFactory;

use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecretController extends Controller
{

    public function create(Request $request)
    {
        $secretCreateServiceRequest = new SecretCreateServiceRequest();
        $secretId = SecretIdFactory::create(Uuid::uuid4());
        $secretCreateServiceRequest->setSecretId($secretId);
        $protocol =  empty($request->server->get('HTTPS'))
            ? 'http'
            : 'https';
        $secretCreateServiceRequest->setProtocol($protocol);
        $domain =  $request->server->get('HTTP_HOST');
        $secretCreateServiceRequest->setDomain($domain);
        $message = $request->request->get('message');
        $secretCreateServiceRequest->setMessage($message);

        $secretFactory = new SecretFactoryImp();
        $service = new SecretCreateService($secretFactory);
        $secretCreateServiceResponse = $service->execute($secretCreateServiceRequest);

        return $this->render('secret/created.html.twig', [
            'response' => $secretCreateServiceResponse
        ]);
    }
}