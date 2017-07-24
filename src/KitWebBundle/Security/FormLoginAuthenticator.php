<?php
namespace KitWebBundle\Security;

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
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
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
        if ($request->getPathInfo() != '/login_check') {
            return;
        }
        
        $email = $request->request->get('email');
        $request->getSession()->set(Security::LAST_USERNAME, $email);
        $password = $request->request->get('password');
        
        return [
            'email' => $email,
            'password' => $password
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            return $userProvider->loadUserByUsername($credentials['email']);
        }
        catch (UsernameNotFoundException $e) {
            throw new CustomUserMessageAuthenticationException('用户不存在');
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];
        if ($this->encoder->isPasswordValid($user, $plainPassword)) {
            return true;
        }
        
        throw new CustomUserMessageAuthenticationException('密码错误');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = $this->router->generate('kit_user_homepage');
        
        return new RedirectResponse($url);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        
        $url = $this->router->generate('kit_web_login');
        
        return new RedirectResponse($url);
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('kit_web_login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('kit_web_homepage');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}