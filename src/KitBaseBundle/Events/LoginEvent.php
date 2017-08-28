<?php
namespace KitBaseBundle\Events;

use Symfony\Component\EventDispatcher\Event;

class LoginEvent extends Event
{
    private $who;
    private $what;
    private $when;
    
    public function __construct($who, $what)
    {
        $this->who = $who;
        $this->what = $what;
        $this->when = new \DateTime();
    }
    
    public function who()
    {
        return $this->who;
    }
    
    public function what()
    {
        return $this->what;
    }
    
    public function when()
    {
        return $this->when;
    }
}