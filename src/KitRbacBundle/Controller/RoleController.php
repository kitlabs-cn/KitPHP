<?php
namespace KitRbacBundle\Controller;

use KitBaseBundle\Controller\BaseController;
use KitRbacBundle\Entity\Role;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use KitRbacBundle\Form\Type\RoleType;

class RoleController extends BaseController
{

    public function indexAction($page)
    {
        if($page < 1) $page = 1;
        $pagesize = 5;
        $repository = $this->getDoctrine()->getRepository('KitRbacBundle:Role');
        $list = $repository->getList();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $page,
            $pagesize
        );
        return $this->render('KitRbacBundle:Role:index.html.twig', [
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
        $em = $this->getEntityManager();
        $errors = [];
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        /**
        $form = $this->createFormBuilder($role)
            ->add('rolename', null, [
            'label' => '用户组名称'
        ])
            ->add('note', null, [
            'label' => '备注'
        ])
            ->add('status', ChoiceType::class, [
            'choices' => [
                '启用' => 1,
                '禁用' => 0
            ],
            'expanded' => true,
            'label' => '状态',
            'label_attr' => [
                'class' => 'radio-inline'
            ]
        ])
            ->add('submit', SubmitType::class, [
            'label' => '提交'
        ])
            ->getForm();
        **/
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /**
                 */
                $role = $form->getData();
                $role->setIp($request->getClientIp());
                $em->persist($role);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '添加成功', 'kit_rbac_role');
            } else {
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('KitRbacBundle:Role:add.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function delAction()
    {
        return $this->render('KitRbacBundle:Role:index.html.twig');
    }
}
