<?php
namespace KitAdminBundle\Controller;

use KitBaseBundle\Controller\BaseController;
use KitWebBundle\Entity\WebReport;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends BaseController
{

    /**
     * Lists all report entities.
     *
     */
    public function indexAction($page)
    {
        if($page < 1) $page = 1;
        $pagesize = 5;
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('KitWebBundle:WebReport')->findBy([] , [
            'id' => 'DESC'
        ]);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $page,
            $pagesize
        );
        return $this->render('KitAdminBundle:Report:index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * Finds and displays a matter entity.
     *
     */
    public function showAction(WebReport $report)
    {

        return $this->render('KitAdminBundle:Report:show.html.twig', array(
            'item' => $report
        ));
    }
    public function deleteAction(Request $request)
    {
        $id = $request->request->get('id');
        $item = $this->getDoctrine()
        ->getRepository('KitWebBundle:WebReport')
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