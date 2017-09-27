<?php
namespace KitApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CaptchaController extends Controller
{
    public function indexAction(Request $request)
    {
        $key = $request->query->get('key', 'login');
        $keys = ['login', 'register'];
        if(!in_array($key, $keys)){
            return $this->json([
                'code' => 0,
                'error' => 'key error'
            ]);
        }
        /**
         * @var \Symfony\Component\HttpFoundation\Session\Session $session
         */
        $session = $this->get('session');
        $session->set('captcha_whitelist_key', $keys);
        return $this->redirectToRoute('gregwar_captcha.generate_captcha', ['key' => $key]);
    }
}