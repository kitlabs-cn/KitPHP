<?php
namespace KitAdminBundle\Controller;

use KitBaseBundle\Controller\BaseController;
use KitWebBundle\Entity\WebUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
class UserController extends BaseController
{

    /**
     * Lists all WebUser entities.
     *
     */
    public function indexAction($page)
    {
        if($page < 1) $page = 1;
        $pagesize = 5;
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('KitWebBundle:WebUser')->findBy([], [
            'id' => 'DESC'
        ]);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $page,
            $pagesize
        );
        return $this->render('KitAdminBundle:User:index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * Finds and displays a WebUser entity.
     *
     */
    public function showAction(WebUser $user)
    {

        return $this->render('KitAdminBundle:User:show.html.twig', array(
            'item' => $user
        ));
    }
    
    public function checkAction($id, Request $request)
    {
        $errors = [];
        $em = $this->getEntityManager();
        $admin = $this->getUser();
        $user = $em->getRepository('KitWebBundle:WebUser')->find($id);
        $form = $this->createFormBuilder($user)
        ->add('status', ChoiceType::class, [
                'choices'  => [
                    '审核通过' => 2,
                    '拒绝通过' => 3
                ],
                'expanded' => true,
                'label' => '审核状态',
                'data' => 2,
                'label_attr' => [
                    'class' =>'radio-inline'
                ]
            ])
        ->add('note', TextareaType::class, [
            'label' => '备注'
        ])
        ->add('submit', SubmitType::class, [
            'label' => '提交',
            'attr' => [
                'class' => 'button bg-main'
            ]
        ])
        ->getForm();
    
        $form->handleRequest($request);
        $user = $form->getData();
        if ($form->isSubmitted()) {
            //if ($form->isValid()) {
                /**
                 *
                 * @var $user \KitWebBundle\Entity\WebUser
                 */
                $user = $form->getData();
                $em->persist($user);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '修改成功', 'kit_admin_user');
//             } else {
//                 $errors = $this->serializeFormErrors($form);
//             }
        }
        return $this->render('KitAdminBundle:User:info.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
            'item' => $user
        ]);
    }
    
    /**
     * 修改密码
     * @param Request $request
     * @return \KitBaseBundle\Controller\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function passwordAction(Request $request)
    {
        $errors = [];
        $em = $this->getEntityManager();
        $user = $this->getUser();
        $hash = $user->getPassword();
        $form = $this->createFormBuilder($user)
        ->add('password', PasswordType::class, [
            'label' => '原始密码'
        ])
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => '新密码'
            ],
            'second_options' => [
                'label' => '确认密码'
            ]
        ])
        ->getForm();
    
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /**
                 */
                $userForm = $form->getData();
                if (password_verify($userForm->getPassword() . $user->getSalt(), $hash)) {
                    $user->setPassword($userForm->getPlainPassword());
                    $em->persist($user);
                    $em->flush();
                    return $this->msgResponse(0, '恭喜', '修改成功,请重新登录', 'kit_admin_logout');
                } else {
                    $errors[] = '原始密码错误';
                }
            } else {
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('KitAdminBundle:User:password.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }
}