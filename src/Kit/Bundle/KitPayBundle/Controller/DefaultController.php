<?php

namespace Kit\Bundle\KitPayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /**
         * @var \Kit\Bundle\KitPayBundle\Service\PaymentService $paymentService
         */
        $paymentService = $this->get('kit_pay.payment_service');
        $paymentService->run($channel, $metadata);
        return $this->render('KitPayBundle:Default:index.html.twig');
    }
}
