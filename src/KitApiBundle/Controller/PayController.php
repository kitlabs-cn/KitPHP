<?php
namespace KitApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PayController extends Controller
{
    public function indexAction()
    {
        return $this->render('KitApiBundle:Default:index.html.twig');
    }
}