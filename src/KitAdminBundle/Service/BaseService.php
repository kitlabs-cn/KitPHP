<?php
namespace KitAdminBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class BaseService
{
    private $container;
    /**
     * 
     * @var Doctrine\ORM\EntityManager
     */
    private $em;
    /**
     *
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
        $this->em = $this->doctrine->getManager();
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
        
        return (isset($theme['path']) && !empty($theme['path'])) ? $theme['path'] : $default;
    }
    
}  