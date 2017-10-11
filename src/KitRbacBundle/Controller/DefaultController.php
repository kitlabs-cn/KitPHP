<?php
namespace KitRbacBundle\Controller;

use KitBaseBundle\Controller\BaseController;
use KitRbacBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use RbacBundle\Form\Type\UserType;

class DefaultController extends BaseController
{

    public function indexAction(Request $request)
    {
        dump('ds');
        $pagesize = 10;
        $repository = $this->getDoctrine()->getRepository('RbacBundle:User');
        $list = $repository->getList();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $request->query->getInt('page', 1),
            $pagesize
        );
        return $this->render('RbacBundle:Default:index.html.twig', [
            'pagination' => $pagination
        ]);
    }
    /**
     * add user
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $errors = [];
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $user->setIp($request->getClientIp());
                $user->setRole('ROLE_ADMIN');
                $em->persist($user);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '添加成功', 'kit_rbac_user');
            }else{
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('RbacBundle:Default:add.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    /**
     * edit user
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request)
    {
        $id = $request->query->getInt('id');
        $errors = [];
        $user = $this->getDoctrine()->getRepository('RbacBundle:User')->find($id);
        if(!$user){
            return $this->msgResponse(2, '警告', '该记录不存在', 'kit_rbac_user');
        }
        $oldPass = $user->getPassword();
        $form = $this->createForm(UserType::class, $user);
    
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                if($user->getPassword() == null){
                    $user->setPassword($oldPass);
                }
                $user->setIp($request->getClientIp());
                $user->setRole('ROLE_ADMIN');
                $em->persist($user);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '修改成功', 'rbac_user');
            }else{
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('RbacBundle:Default:add.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }
    
    public function deleteAction(Request $request)
    {
        $id = $request->request->get('id');
        $item = $this->getDoctrine()
        ->getRepository('RbacBundle:User')
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
