<?php

namespace App\Controller;

use App\domain\Entities\Secret\SecretFactoryImp;
use App\domain\ValueObjects\Secret\SecretIdImp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecretController extends Controller
{
    public function create(Request $request)
    {

        $secretId = SecretIdImp::create(uniqid());
        $message = $request->request->get('message');
        $secret = SecretFactoryImp::create($secretId, $message);

        $host =  $request->server->get('HTTP_HOST');
        $protocol =  empty($request->server->get('HTTPS'))
            ? 'http'
            : 'https';
        $url = $protocol . '://' . $host . '/secret/' . $secretId->getIdentifier();


        return $this->render('secret/created.html.twig', [
            'url' => $url,
            'secret' => $secret
        ]);
    }
}