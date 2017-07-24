<?php
namespace KitAdminBundle\Controller;

use KitBaseBundle\Controller\BaseController;
use KitAdminBundle\Entity\Admin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use KitAdminBundle\Form\Type\FulltextType;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends BaseController
{

    public function indexAction()
    {
        return $this->render('KitAdminBundle:Default:index.html.twig');
    }
    public function flowAction()
    {
        return $this->render('KitAdminBundle:Default:flow.html.twig');
    }
    public function listAction()
    {
        $em = $this->getEntityManager();
        $list = $em->getRepository("KitAdminBundle:Admin")->getAllAdmins();
        return $this->render('KitAdminBundle:Default:list.html.twig', [
            'list' => $list
        ]);
    }

    public function addAction(Request $request)
    {
        $admin = new Admin();
        
        $form = $this->createFormBuilder($admin)
            ->add('username', null, ['label' => '用户名'])
            ->add('password', PasswordType::class, [
            'attr' => [
                'input-note' => '密码为6-16位'
            ],
            'label' => '密码'
        ])
            ->add('truename')
            ->add('cardid')
            ->add('number')
            ->add('gender')
            ->add('mobile')
            ->add('city_id')
            ->add('suboffice_id')
            ->add('job_title', FulltextType::class, [
                'attr' => [
                    'id' => 'myEditor',
                    'width' => '80%',
                    'height' => '240px'
                ]
            ])
            ->add('admin_role_id')
            ->add('submit', SubmitType::class)
            ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             */
            $admin = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
            $this->redirectToRoute('kit_admin_add_success');
        }
        return $this->render('KitAdminBundle:Default:index.html.twig', [
            'form' =>$form->createView()
        ]);
    }
    
    public function addSuccessAction()
    {
        return new JsonResponse(['msg' => 'success']);
    }
    
    public function loginAction()
    {
        
    }
    
    public function logoutAction()
    {
    
    }
    /**
     * fulltext images upload
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function uploadAction(Request $request)
    {
        /**
         * @var $image \Symfony\Component\HttpFoundation\File\UploadedFile
         */
        $image = $request->files->get('upfile');
        $fileName = $this->get('kit.file_uploader')->upload($image, 'image/' . date('Y/m'));
    
        /*"state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
        **/
        return new Response(json_encode([
            'state' => 'SUCCESS',
            'url' => '/uploads'. $fileName,
            'title' => '',
            'original' => '',
            'type' => 'png',
            'size' => 1024
        ]));
    }
}
