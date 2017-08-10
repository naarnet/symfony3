<?php

namespace GestoriaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestoriaBundle:Default:index.html.twig');
    }
}
