<?php
namespace KitAdminBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class AdminFormLoginAuthenticator extends AbstractFormLoginAuthenticator
{

    private $router;

    private $encoder;

    public function __construct(RouterInterface $router, UserPasswordEncoderInterface $encoder)
    {
        $this->router = $router;
        $this->encoder = $encoder;
    }

    public function getCredentials(Request $request)
    {
        //dump($request->getPathInfo());die();
        if ($request->getPathInfo() != '/admin/login_check') {
            return;
        }
        
        $username = $request->request->get('_username');
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        $password = $request->request->get('_password');
        
        return [
            'username' => $username,
            'password' => $password
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            return $userProvider->loadUserByUsername($credentials['username']);
        }catch (UsernameNotFoundException $e) {
            throw new CustomUserMessageAuthenticationException('用户名不存在');
        }
        
        
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $salt = $user->getSalt();
        if ($this->encoder->isPasswordValid($user, $credentials['password'] . $salt)) {
            return true;
        }
        throw new CustomUserMessageAuthenticationException('密码错误');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = $this->router->generate('kit_admin_homepage');
        
        return new RedirectResponse($url);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        
        $url = $this->router->generate('kit_admin_login');
        
        return new RedirectResponse($url);
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('kit_admin_login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('kit_admin_homepage');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}