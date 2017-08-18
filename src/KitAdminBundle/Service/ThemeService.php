<?php
namespace KitAdminBundle\Service;

class ThemeService
{
    /**
     *
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;
    
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    public function get($default = 'Default')
    {
        /**
         *
         * @var \KitAdminBundle\Repository\ThemeRepository $repo
         */
        $repo = $this->doctrine->getRepository('KitAdminBundle:Theme');
        $theme = $repo->findOneBy([
            'status' => 1
        ]);
        
        return (!empty($theme) && !empty($theme->getPath())) ? $theme->getPath() : $default;
    }
    
}  