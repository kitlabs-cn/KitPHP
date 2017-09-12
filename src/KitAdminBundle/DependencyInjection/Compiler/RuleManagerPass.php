<?php
namespace KitAdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RuleManagerPass implements CompilerPassInterface
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        if(!$container->has('kit_admin.rule_manager_service')){
            return ;
        }
        $definition = $container->findDefinition('kit_admin.rule_manager_service');
        $taggedServices = $container->findTaggedServiceIds('rule_manager.rule');
        
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addRule',
                array(new Reference($id))
            );
        }
    }
}