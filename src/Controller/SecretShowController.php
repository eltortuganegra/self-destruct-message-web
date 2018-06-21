<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecretShowController extends Controller
{
    public function index()
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
