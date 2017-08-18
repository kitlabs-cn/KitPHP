<?php
namespace KitWebBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ThemeExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function getGlobals()
    {
        return array(
            'theme_name' => 'myThemeName'
        );
    }
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('theme', array($this, 'themeFilter')),
        );
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('theme', array($this, 'themeFunction')),
        );
    }
    
    public function themeFilter($resource, $default = 'Default')
    {
        
        return 'theme/'.$resource;
    }
    
    public function themeFunction($resource, $default = 'Default')
    {
        return 'theme/'.$resource;
    }
}