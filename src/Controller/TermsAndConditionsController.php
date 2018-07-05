<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TermsAndConditionsController extends Controller
{
    public function index()
    {
        return $this->render('terms_and_conditions/index.html.twig');
    }
}