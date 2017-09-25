<?php
namespace KitApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PayController extends Controller
{
    public function indexAction()
    {
        $unionPay = $this->get('kit_api.pai_union');
        $response = $unionPay->run('pay');
        dump($response);
        return $this->render('KitApiBundle:Default:index.html.twig');
    }
}