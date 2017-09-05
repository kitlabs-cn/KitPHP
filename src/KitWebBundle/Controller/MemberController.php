<?php
namespace KitWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use KitWebBundle\Entity\WebUser;
use KitBaseBundle\Controller\BaseController;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

class MemberController extends BaseController
{
    /**
     * 注册
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function registerAction(Request $request)
    {
        $mobile = $request->request->get('mobile', null);
        $code = $request->request->get('code', null);
        $password = $request->request->get('password', null);
        $repassword = $request->request->get('repassword', null);
        if(empty($mobile)){
            return $this->json([
                'code' => 2,
                'msg' => '请填写手机号'
            ]);
        }
        if(empty($code)){
            return $this->json([
                'code' => 3,
                'msg' => '请填写验证码'
            ]);
        }
        if(empty($password)){
            return $this->json([
                'code' => 4,
                'msg' => '请填写密码'
            ]);
        }
        if($password != $repassword){
            return $this->json([
                'code' => 5,
                'msg' => '两次密码不一致'
            ]);
        }
        $codeToken = $request->getSession()->get('code_token', '');
        if($codeToken != md5('register'. $mobile .'pdd'. $code)){
            return $this->json([
                'code' => 6,
                'msg' => '验证码校验失败'
            ]);
        }
        $user = new WebUser();
        // Encode the new users password
        $encoder = $this->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $password);
        $user->setMobile($mobile);
        $user->setPassword($password);
        // Set their role
        $user->setRole('ROLE_USER');
        /**
         *
         * @var $assets \Symfony\Component\Asset\Packages
         */
        $assets = $this->container->get('assets.packages');
        $user->setAvatar($assets->getUrl('asset/images/default.jpg'));
        $user->setName($mobile);
        $user->setStatus(0);
        $user->setUserType(0);
        $user->setNumber(0);
        $user->setUsed(0);
        $user->setTotal(0);
        $user->setToken(uniqid());
        // Save
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->authenticateUser($user, '注册成功');
    }
    /**
     * 登录
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $mobile = $request->request->get('mobile', null);
        $password = $request->request->get('password', null);
        if(empty($mobile)){
            return $this->json([
                'code' => 2,
                'msg' => '请填写手机号'
            ]);
        }
        if(empty($password)){
            return $this->json([
                'code' => 4,
                'msg' => '请填写密码'
            ]);
        }
        /**
         *
         * @var \KitWebBundle\Entity\WebUser $user
         */
        $user = $this->getDoctrine()->getRepository('KitWebBundle:WebUser')->findOneBy([
            'mobile' => $mobile
        ]);
        if(empty($user)){
            return $this->json([
                'code' => 5,
                'msg' => '用户不存在'
            ]);
        }
        /**
         *
         * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoder
         */
        $encoder = $this->get('security.password_encoder');
        // 校验密码
        if ($encoder->isPasswordValid($user, $password)) {
            return $this->authenticateUser($user, '登录成功');
        }else{
            return $this->json([
                'code' => 6,
                'msg' => '密码错误'
            ]);
        }
    }
    
    /**
     * 忘记密码
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function forgetAction(Request $request)
    {
        $mobile = $request->request->get('mobile', null);
        $code = $request->request->get('code', null);
        $password = $request->request->get('password', null);
        $repassword = $request->request->get('repassword', null);
        if(empty($mobile)){
            return $this->json([
                'code' => 2,
                'msg' => '请填写手机号'
            ]);
        }
        if(empty($code)){
            return $this->json([
                'code' => 3,
                'msg' => '请填写验证码'
            ]);
        }
        if(empty($password)){
            return $this->json([
                'code' => 4,
                'msg' => '请填写密码'
            ]);
        }
        if($password != $repassword){
            return $this->json([
                'code' => 5,
                'msg' => '两次密码不一致'
            ]);
        }
        $codeToken = $request->getSession()->get('code_token', '');
        if($codeToken != md5('forget'. $mobile .'pdd'. $code)){
            return $this->json([
                'code' => 6,
                'msg' => '验证码校验失败'
            ]);
        }
        /**
         * 
         * @var \KitWebBundle\Entity\WebUser $user
         */
        $user = $this->getDoctrine()->getRepository('KitWebBundle:WebUser')->findOneBy([
            'mobile' => $mobile
        ]);
        if(empty($user)){
            return $this->json([
                'code' => 7,
                'msg' => '用户不存在'
            ]);
        }
        // Encode the new users password
        $encoder = $this->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $password);
        $user->setPassword($password);
        // Save
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->json([
            'code' => 1,
            'msg' => '成功找回密码'
        ]);
    }
    
    public function smsAction(Request $request)
    {
        $type = $request->query->get('type', '');
        $mobile = $request->request->get('mobile', '');
        if(!preg_match('/^1[34578][0-9]{9}$/', $mobile)){
            return $this->json([
                'code' => 2,
                'msg' => '手机号格式不正确'
            ]);
        }
        /**
         *
         * @var \KitWebBundle\Entity\WebUser $user
         */
        $user = $this->getDoctrine()->getRepository('KitWebBundle:WebUser')->findOneBy([
            'mobile' => $mobile
        ]);
        switch ($type) {
            case 'forget':
                if(empty($user)){
                    return $this->json([
                        'code' => 3,
                        'msg' => '用户不存在'
                    ]);
                }
                break;
            default:
                // register
                $type = 'register';
                if(!empty($user)){
                    return $this->json([
                        'code' => 4,
                        'msg' => '用户已注册'
                    ]);
                }
                break;
        }
        $code = $this->generateCode(6);
        $response = $this->requestSms('register', $mobile, $code);
        if(1 == $response['code']){
            // 存入session
            $request->getSession()->set('code_token', md5($type . $mobile . 'pdd' . $code));
            return $this->json([
                'code' => 1,
                'msg' => '发送成功',
            ]);
        }else{
            return $this->json([
                'code' => 5,
                'msg' => '发送失败',
            ]);
        }
    }
    
    /**
     *
     * @param number $len
     */
    private function generateCode($len = 4)
    {
        return substr(str_shuffle('1234567890'), 0, $len);
        
    }
    
    /**
     *
     */
    private function requestSms($type, $mobile, $code)
    {
        /**
         *
         * @var \KitBaseBundle\Service\SmsService $smsService
         */
        $smsService = $this->get('kit.base_sms');
        return $smsService->request($type, $mobile, $code);
    }
    /**
     * 设置登录信息
     * 
     * @param WebUser $user
     */
    private function authenticateUser(WebUser $user, $msg)
    {
        $providerKey = 'main'; // your firewall name
        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $response = new JsonResponse([
            'code' => 1,
            'msg' => $msg
        ]);
        $response->headers->setCookie(new Cookie('pdd_login', uniqid()));
        return $response;
    }
}