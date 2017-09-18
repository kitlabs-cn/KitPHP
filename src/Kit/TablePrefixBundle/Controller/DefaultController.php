<?php

namespace Kit\TablePrefixBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KitTablePrefixBundle:Default:index.html.twig');
    }
}
