<?php
namespace KitBaseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

class BaseController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function baseAction(Request $request)
    {
        // $menuBulider = $this->get('kit.menu_builder');
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR
        ]
        // 'main' => $menuBulider->createMainMenu([]),
        );
    }
    /**
     * 格式化form表单的错误
     * 
     * @param Form $form
     * @return array
     */
    protected function serializeFormErrors(Form $form)
    {
        $errors = [];
        /**
         * @var  $key
         * @var Form $child
        */
        foreach ($form->all() as $key => $child) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$key] = $error->getMessage();
                }
            }
        }
    
        return $errors;
    }
    /**
     * Get Entity Manager
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * Doctrine对象
     * 
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    public function em()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * msg response
     *
     * @param int $type
     *            消息类型(0为绿色,1为蓝色, 2为红色)
     * @param string $title
     *            提示
     * @param string $msg
     *            消息       
     * @param routeName $routeName
     *            路由名称
     * @param string $timeout
     *            消息提示的时间
     * @return Response
     */
    protected function msgResponse($type = 0, $title = '提示', $msg = '操作成功！', $routeName = 'kit_admin', $timeout = 3)
    {
        $classes = [
            'main', // 绿色
            'sub', // 蓝色
            'dot' // 红色
        ];
        $uri = $this->generateUrl($routeName);
        return $this->render('KitAdminBundle:Common:pintuer_msg.html.twig', [
            'type' => $type,
            'timeout' => $timeout,
            'title' => $title,
            'msg' => $msg,
            'uri' => $uri,
            'class' => isset($classes[$type]) ? $classes[$type] : $classes[0]
        ]);
    }
    
    /**
     * flash response
     *
     * @param int $type
     *            消息类型(0为绿色,1为蓝色, 2为红色)
     * @param string $title
     *            提示
     * @param string $msg
     *            消息
     * @param routeName $routeName
     *            路由名称
     * @param string $timeout
     *            消息提示的时间
     * @return Response
     */
    protected function flashResponse($type = 0, $title = '提示', $msg = '操作成功！', $routeName = 'kit_admin', $timeout = 3)
    {
        $classes = [
            'main', // 绿色
            'sub', // 蓝色
            'dot' // 红色
        ];
        $uri = $this->generateUrl($routeName);
        return $this->render('KitWebBundle:Common:pintuer_msg.html.twig', [
            'type' => $type,
            'timeout' => $timeout,
            'title' => $title,
            'msg' => $msg,
            'uri' => $uri,
            'class' => isset($classes[$type]) ? $classes[$type] : $classes[0]
        ]);
    }
    /**
     *
     * @author gf
     *         创建消息提示响应
     *        
     * @param string $type
     *            消息类型（0为成功(success) 1为信息(info) 2为(primary) 3为警告(warning) 4为失败(danger) ）
     * @param string $message
     *            消息内容
     * @param integer $goto
     *            消息跳转的页面
     * @param string $sec
     *            消息提示的时间
     * @return Response
     */
    protected function createMessageResponse($type = 0, $message = '操作成功！', $goto = null, $sec = 3)
    {
        switch (intval($type)) {
            case 0:
                $typeClass = 'success';
                break;
            case 1:
                $typeClass = 'info';
                break;
            case 2:
                $typeClass = 'primary';
                break;
            case 3:
                $typeClass = 'warning';
                break;
            case 4:
                $typeClass = 'danger';
                break;
        }
        
        return $this->render('KitAdminBundle:Common:message.html.twig', array(
            'sec' => $sec,
            'type' => $type,
            'message' => $message,
            'url' => $goto,
            'typeclass' => $typeClass
        ));
    }

    /**
     *
     * @author gf
     *        
     *         flash提示
     *        
     * @param
     *            $level
     * @param
     *            $message
     */
    protected function setFlashMessage($level, $message)
    {
        $this->get('session')
            ->getFlashBag()
            ->add($level, $message);
    }

    /**
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getCaseRegisterRepository()
	{
		return $this->em()->getRepository('KitCaseBundle:CaseRegister');
	}
	/**
	 * 
	 */
	protected function dialog($controller, $id)
	{
	    return $this->render('dialog.html.twig', [
	        'title' => 'title',
	        'controller' => $controller,
	        'id' => $id
	    ]);
	}
}

