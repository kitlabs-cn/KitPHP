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
            'theme_name' => $this->getThemeName()
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
        
        return 'theme/'. $this->getThemeName($default) . '/' . $resource;
    }
    
    public function themeFunction($resource, $default = 'Default')
    {
        return 'theme/'. $this->getThemeName($default) . '/' . $resource;
    }
    
    private function getThemeName($default = 'Default')
    {
        /**
         * @var \KitAdminBundle\Service\ThemeService $themeService
         */
        $themeService = $this->container->get('kit_admin.theme_service');
        return $themeService->get($default);
    }
}