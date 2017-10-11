<?php
namespace KitAdminBundle\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoginController extends Controller
{

    public function loginAction(Request $request)
    {
        /**
         *
         * @var \Kit\CryptBundle\Service\OpensslService $opensslService
         */
        $opensslService = $this->get('kit_crypt.openssl');
        $encrypt = $opensslService->encrypt('lcp0578');
        dump($encrypt);
        dump($opensslService->decrypt($encrypt));
        $helper = $this->get('security.authentication_utils');
        
        return $this->render('KitAdminBundle:Login:login.html.twig', array(
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ));
    }

    public function logoutAction()
    {
        return $this->redirectToRoute('kit_admin_login', [], 302);
    }
    
    public function loginCheckAction()
    {}
}
