<?php
namespace KitAdminBundle\Controller;

use KitBaseBundle\Controller\BaseController;
use KitWebBundle\Entity\WebAppeal;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AppealController extends BaseController
{

    /**
     * Lists all Appeal entities.
     *
     */
    public function indexAction($page)
    {
        if($page < 1) $page = 1;
        $pagesize = 5;
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('KitWebBundle:WebAppeal')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $page,
            $pagesize
        );
        return $this->render('KitAdminBundle:Appeal:index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * Finds and displays a appeal entity.
     *
     */
    public function showAction(WebAppeal $appeal)
    {

        return $this->render('KitAdminBundle:Appeal:show.html.twig', array(
            'item' => $appeal
        ));
    }
    
    public function deleteAction(Request $request)
    {
        $id = $request->request->get('id');
        $item = $this->getDoctrine()
        ->getRepository('KitWebBundle:WebAppeal')
        ->find($id);
        if(!$item){
            return new JsonResponse([
                'status' => 0,
                'msg' => '记录不存在'
            ]);
        }else{
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($item);
            $em->flush();
            return new JsonResponse([
                'status' => 1,
                'msg' => '删除成功'
            ]);
        }
    }
}