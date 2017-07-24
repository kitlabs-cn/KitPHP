<?php
namespace KitWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use KitWebBundle\Form\WebUserType;
use KitWebBundle\Entity\WebUser;
use KitBaseBundle\Controller\BaseController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use KitWebBundle\Entity\WebAppeal;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use KitWebBundle\Entity\WebReport;
use KitSceneBundle\Entity\Matter;
use KitSceneBundle\Entity\Notice;

class UserController extends BaseController
{

    public function indexAction()
    {
        return $this->render('KitWebBundle:User:index.html.twig', [
            'nav' => 8
        ]);
    }

    public function registerAction(Request $request)
    {
        $errors = [];
        // Create a new blank user and process the form
        $user = new WebUser();
        $form = $this->createForm(WebUserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setStatus(0);
            $user->setUserType(0);
            // Set their role
            $user->setRole('ROLE_USER');
            /**
             *
             * @var $assets \Symfony\Component\Asset\Packages
             */
            $assets = $this->container->get('assets.packages');
            $user->setAvatar($assets->getUrl('asset/images/default.jpg'));
            
            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            return $this->flashResponse(0, '恭喜您', '注册成功', 'kit_web_login');
        } else {
            $errors = $this->serializeFormErrors($form);
        }
        
        return $this->render('KitWebBundle:User:register.html.twig', [
            'nav' => 8,
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function loginAction(Request $request)
    {
        $helper = $this->get('security.authentication_utils');
        
        return $this->render('KitWebBundle:User:login.html.twig', array(
            'nav' => 8,
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ));
    }

    public function loginCheckAction()
    {}

    public function logoutAction()
    {}

    /**
     */
    public function passwordAction(Request $request)
    {
        $errors = [];
        $em = $this->getEntityManager();
        $user = new WebUser();
        
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
                $user = $this->getUser();
                /**
                 *
                 * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoder
                 */
                $encoder = $this->get('security.password_encoder');
                if ($encoder->isPasswordValid($user, $userForm->getPassword())) {
                    $password = $encoder->encodePassword($user, $userForm->getPlainPassword());
                    $user->setPassword($password);
                    $em->persist($user);
                    $em->flush();
                    return $this->flashResponse(0, '恭喜', '修改成功', 'kit_web_user');
                } else {
                    $errors[] = '原始密码错误';
                }
            } else {
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('KitWebBundle:User:password.html.twig', [
            'nav' => 8,
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function infoAction(Request $request)
    {
        $errors = [];
        $em = $this->getEntityManager();
        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        
        $form = $this->createFormBuilder($user)
            ->add('name', null, [
            'label' => '用户名称'
        ])
            ->add('avatar', FileType::class, [
            'data_class' => null,
            'label' => '用户头像'
        ])
            ->add('submit', SubmitType::class, [
            'label' => '确定修改',
            'attr' => [
                'class' => ' border-main'
            ]
        ])
            ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
//             if ($form->isValid()) {
                /**
                 *
                 * @var $user \KitWebBundle\Entity\WebUser
                 */
                $user = $form->getData();
                $avatar = $user->getAvatar();
                if ($avatar instanceof UploadedFile) {
                    $fileName = $this->get('kit.file_uploader')->upload($avatar, 'avatar');
                    $user->setAvatar('/uploads' . $fileName);
                    $em->persist($user);
                    $em->flush();
                    return $this->flashResponse(0, '恭喜', '修改成功', 'kit_user_homepage');
                } else {
                    $errors[] = '请上传头像';
                }
//             } else {
//                 $errors = $this->serializeFormErrors($form);
//             }
        }
        return $this->render('KitWebBundle:User:info.html.twig', [
            'nav' => 8,
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function companyAction(Request $request)
    {
        $errors = [];
        $em = $this->getEntityManager();
        $user = $this->getUser();
        $status = $user->getStatus();
        $userType = $user->getUserType();
        if (1 == $status && $userType > 0) {
            
            if (1 == $userType) {
                $tips = '您已申请企业(' . $user->getCompany() . ')认证，请耐心等待管理员审核';
            } else {
                $tips = '您已申请其他部门(' . $user->getCompany() . ')认证，请耐心等待管理员审核';
            }
            return $this->render('KitWebBundle:User:tips.html.twig', [
                'nav' => 8,
                'tips' => $tips
            ]);
        }
        $form = $this->createFormBuilder($user)
            ->add('company', null, [
            'label' => '公司名称'
        ])
            ->add('legal', null, [
            'label' => '公司法人'
        ])
            ->add('telephone', null, [
            'label' => '公司电话'
        ])
            ->add('license', FileType::class, [
            'data_class' => null,
            'label' => '营业执照'
        ])
            ->add('submit', SubmitType::class, [
            'label' => '提交申请',
            'attr' => [
                'class' => 'button button-block bg-main text-big'
            ]
        ])
            ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // if ($form->isValid()) {
            /**
             *
             * @var $user \KitWebBundle\Entity\WebUser
             */
            $user = $form->getData();
            $license = $user->getLicense();
            if ($license instanceof UploadedFile) {
                $fileName = $this->get('kit.file_uploader')->upload($license, 'license');
                $user->setLicense('/uploads' . $fileName);
                $user->setStatus(1);
                $user->setUserType(1);
                $em->persist($user);
                $em->flush();
                return $this->flashResponse(0, '恭喜', '申请成功', 'kit_user_homepage');
            } else {
                $errors[] = '请上传营业执照';
            }
            // } else {
            // $errors = $this->serializeFormErrors($form);
            // }
        }
        return $this->render('KitWebBundle:User:info.html.twig', [
            'nav' => 8,
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function deptAction(Request $request)
    {
        $errors = [];
        $em = $this->getEntityManager();
        $user = $this->getUser();
        $status = $user->getStatus();
        $userType = $user->getUserType();
        if (1 == $status && $userType > 0) {
            
            if (1 == $userType) {
                $tips = '您已申请企业(' . $user->getCompany() . ')认证，请耐心等待管理员审核';
            } else {
                $tips = '您已申请其他部门(' . $user->getCompany() . ')认证，请耐心等待管理员审核';
            }
            return $this->render('KitWebBundle:User:tips.html.twig', [
                'nav' => 8,
                'tips' => $tips
            ]);
        }
        $form = $this->createFormBuilder($user)
            ->add('company', null, [
            'label' => '部门名称'
        ])
            ->add('legal', null, [
            'label' => '本人姓名'
        ])
            ->add('telephone', null, [
            'label' => '部门电话'
        ])
            ->add('license', FileType::class, [
            'data_class' => null,
            'label' => '部门证明'
        ])
            ->add('submit', SubmitType::class, [
            'label' => '提交申请',
            'attr' => [
                'class' => 'button button-block bg-main text-big'
            ]
        ])
            ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // if ($form->isValid()) {
            /**
             *
             * @var $user \KitWebBundle\Entity\WebUser
             */
            $user = $form->getData();
            $license = $user->getLicense();
            if ($license instanceof UploadedFile) {
                $fileName = $this->get('kit.file_uploader')->upload($license, 'license2');
                $user->setLicense('/uploads' . $fileName);
                $user->setStatus(1);
                $user->setUserType(2);
                $em->persist($user);
                $em->flush();
                return $this->flashResponse(0, '恭喜', '申请成功', 'kit_user_homepage');
            } else {
                $errors[] = '部门证明';
            }
            // } else {
            // $errors = $this->serializeFormErrors($form);
            // }
        }
        return $this->render('KitWebBundle:User:info.html.twig', [
            'nav' => 8,
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function appealAction(Request $request)
    {
        $em = $this->getEntityManager();
        $mid = $request->query->get('id');
        /**
         * @var $notice \KitSceneBundle\Entity\Notice
        */
        $notice = $em->getRepository('KitSceneBundle:Notice')->find($mid);
        $errors = [];
        
        $appeal = new WebAppeal();
        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        
        $form = $this->createFormBuilder($appeal)
            ->add('title', null, [
            'label' => '申诉标题'
        ])
            ->add('content', TextareaType::class, [
            'label' => '申诉内容'
        ])
            ->add('submit', SubmitType::class, [
            'label' => '提交申请',
            'attr' => [
                'class' => 'button button-block bg-main text-big'
            ]
        ])
            ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /**
                 *
                 * @var $appeal \KitWebBundle\Entity\WebAppeal
                 */
                $appeal = $form->getData();
                $appeal->setCreateAt(date('Y-m-d H:i:s'));
                $appeal->setCompany($notice->getCompany());
                $appeal->setMatter($notice->getMatter());
                $appeal->setNotice($notice->getTitle());
                $em->persist($appeal);
                $em->flush();
                return $this->flashResponse(0, '恭喜', '申诉提交', 'kit_user_homepage');
            } else {
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('KitWebBundle:User:info.html.twig', [
            'nav' => 8,
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function matterAction(Request $request)
    {
        $errors = [];
        $matter = new Matter();
        $user = $this->getUser();
        $status = $user->getStatus();
        $userType = $user->getUserType();
        if (2 != $status || $userType != 2) {
            return $this->render('KitWebBundle:User:tips.html.twig', [
                'nav' => 8,
                'tips' => '请先进行其他部门认证'
            ]);
        }
        $form = $this->createForm('KitSceneBundle\Form\MatterType', $matter, [
            'disabled' => false
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $matter->setEditor($user->getUsername());
            $matter->setStatus(0);
            $matter->setNeed(0);
            $matter->setSource('其他部门移交:' . $user->getCompany());
            $em->persist($matter);
            $em->flush($matter);
            return $this->flashResponse(0, '恭喜', '已成功提交', 'kit_user_homepage');
        }
        return $this->render('KitWebBundle:User:info.html.twig', [
            'matter' => $matter,
            'nav' => 8,
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function showAction(Notice $notice)
    {
        return $this->render('KitWebBundle:User:show.html.twig', array(
            'item' => $notice,
        ));
    }
    public function noticeAction($page)
    {
        $user = $this->getUser();
        $status = $user->getStatus();
        $userType = $user->getUserType();
        if (2 != $status || $userType != 1) {
            return $this->render('KitWebBundle:User:tips.html.twig', [
                'nav' => 8,
                'tips' => '请先进行企业认证'
            ]);
        }
        if ($page < 1)
            $page = 1;
        $pagesize = 5;
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('KitSceneBundle:Notice')->findBy([
            'company' => $user->getCompany(),
            'noticeType' => 1
        ], [
            'id' => 'DESC'
        ]);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($list, $page, $pagesize);
        return $this->render('KitWebBundle:User:notice.html.twig', array(
            'pagination' => $pagination,
            'nav' => 8
        ));
    }

    public function reportAction(Request $request)
    {
        $errors = [];
        $em = $this->getEntityManager();
        $report = new WebReport();
        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        
        $form = $this->createFormBuilder($report)
            ->add('title', null, [
            'label' => '举报标题'
        ])
            ->add('name', null, [
            'label' => '举报人'
        ])
            ->add('mobile', null, [
            'label' => '举报人手机号'
        ])
            ->add('cardid', null, [
            'label' => '举报人身份证号'
        ])
            ->add('thumb', FileType::class, [
            'label' => '相关图片'
        ])
            ->add('content', TextareaType::class, [
            'label' => '举报内容'
        ])
            ->add('submit', SubmitType::class, [
            'label' => '确认举报',
            'attr' => [
                'class' => 'button button-block bg-main text-big'
            ]
        ])
            ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /**
                 *
                 * @var $appeal \KitWebBundle\Entity\WebAppeal
                 */
                $report = $form->getData();
                $thumb = $report->getThumb();
                if ($thumb instanceof UploadedFile) {
                    $fileName = $this->get('kit.file_uploader')->upload($thumb, 'report');
                    $report->setThumb('/uploads' . $fileName);
                } else {
                     $report->setThumb('');
                }
                $report->setCreateAt(date('Y-m-d H:i:s'));
                $em->persist($report);
                $em->flush();
                return $this->flashResponse(1, '恭喜', '举报成功', 'kit_web_homepage');
            } else {
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('KitWebBundle:User:report.html.twig', [
            'nav' => 7,
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }
}