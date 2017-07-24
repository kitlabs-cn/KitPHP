<?php

namespace KitWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /**
         * @var $repository \KitNewsBundle\Repository\NewsRepository
         */
        $repository = $this->getDoctrine()->getRepository('KitNewsBundle:News');
        $top1 = $repository->getListPage(2, 0, 10);
        $top2 = $repository->getListPage(3, 0, 10);
        
        $bottom1 = $repository->getListPage(4, 0, 10);
        $bottom2 = $repository->getListPage(5, 0, 10);
        
        $notice = $repository->getListPage(6, 0, 10);
        $images = $repository->getListPage(null, 0, 12);
        $toutiao = $repository->getToutiao(1);
        return $this->render('KitWebBundle:Default:index.html.twig', [
            'nav' => 1,
            'toutiao' => $toutiao,
            'top1' => $top1,
            'top2' => $top2,
            'bottom1' => $bottom1,
            'bottom2' => $bottom2,
            'notice' => $notice,
            'images' => $images
        ]);
    }
}
