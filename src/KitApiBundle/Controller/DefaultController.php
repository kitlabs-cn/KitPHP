<?php

namespace KitApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KitApiBundle:Default:index.html.twig');
    }
}
