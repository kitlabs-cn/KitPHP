<?php
namespace KitWebBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginListener
{
    private $session;
    
    public function __construct(Session $session)
    {
        $this->session = $session;
    }
    
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        //$event->getAuthenticationToken()->getUser();
        $event->getRequest()->cookies->set('pdd_login', uniqid());
        $this->session->set('timezone', 'RPC');
    }
}