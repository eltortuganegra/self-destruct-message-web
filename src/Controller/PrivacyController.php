<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PrivacyController extends Controller
{
    public function index()
    {
        return $this->render('privacy/index.html.twig');
    }
}