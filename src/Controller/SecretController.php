<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecretController extends Controller
{
    public function create()
    {
        return $this->render('secret/created.html.twig');
    }
}