<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class SecretController extends Controller
{
    public function create()
    {
        return new Response('', 405);
    }
}