<?php

namespace KitAdminBundle;

use KitBaseBundle\KitBaseBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use KitAdminBundle\DependencyInjection\Compiler\RuleManagerPass;

class KitAdminBundle extends KitBaseBundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RuleManagerPass());
    }
}
