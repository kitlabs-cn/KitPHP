<?php
namespace KitRbacBundle\Controller;

use KitBaseBundle\Controller\BaseController;
use KitRbacBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends BaseController
{

    public function indexAction($page)
    {
        if($page < 1) $page = 1;
        $pagesize = 10;
        $repository = $this->getDoctrine()->getRepository('KitRbacBundle:User');
        $list = $repository->getList();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $page,
            $pagesize
        );
        return $this->render('KitRbacBundle:Default:index.html.twig', [
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
        $em = $this->getEntityManager();
        $user = new User();
        
        $form = $this->createFormBuilder($user)
            ->add('username', null, ['label' => '用户名'])
            ->add('password', PasswordType::class, ['label' => '密码'])
            ->add('roles', EntityType::class, [
                'class' => 'KitRbacBundle:Role',
                'choice_label' => 'rolename',
                'label' => '用户组'
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    '启用' => 1,
                    '禁用' => 0
                ],
                'expanded' => true,
                'label' => '状态',
                'data' => 1,
                'label_attr' => [
                    'class' =>'radio-inline'
                    ]
            ])
            ->add('submit', SubmitType::class, ['label' => '提交'])
            ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()){
                /**
                 */
                $user = $form->getData();
                $user->setIp($request->getClientIp());
                $user->setRole('ROLE_ADMIN');
                $em->persist($user);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '添加成功', 'kit_rbac_user');
            }else{
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('KitRbacBundle:Default:add.html.twig', [
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
    public function updateAction($id, Request $request)
    {
        $errors = [];
        $em = $this->getEntityManager();
        $user = new User();
        $repo = $this->getDoctrine()->getRepository('KitRbacBundle:User');
        $user = $repo->find($id);
        $oldPass = $user->getPassword();
        if(!$user){
            return $this->msgResponse(2, '警告', '该记录不存在', 'kit_rbac_user');
        }
        $form = $this->createFormBuilder($user)
        ->add('username', null, ['label' => '用户名'])
        ->add('password', PasswordType::class, ['label' => '密码'])
        ->add('roles', EntityType::class, [
            'class' => 'KitRbacBundle:Role',
            'choice_label' => 'rolename',
            'label' => '用户组'
        ])
        ->add('status', ChoiceType::class, [
            'choices'  => [
                '启用' => 1,
                '禁用' => 0
            ],
            'expanded' => true,
            'label' => '状态',
            'data' => 1,
            'label_attr' => [
                'class' =>'radio-inline'
            ]
        ])
        ->add('submit', SubmitType::class, ['label' => '提交'])
        ->getForm();
    
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()){
                /**
                 */
                $user = $form->getData();
                if($user->getPassword() == null){
                    $user->setPassword($oldPass);
                }
                $user->setIp($request->getClientIp());
                $user->setRole('ROLE_ADMIN');
                $em->persist($user);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '修改成功', 'kit_rbac_user');
            }else{
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('KitRbacBundle:Default:add.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }
    
    public function deleteAction(Request $request)
    {
        $id = $request->request->get('id');
        $item = $this->getDoctrine()
        ->getRepository('KitRbacBundle:User')
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
