<?php

namespace Perfico\CRMBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class PermissionCompilerPass implements CompilerPassInterface{

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $types = [];
        $services = $container->findTaggedServiceIds('perfico_crm.permission_handler');
        foreach ($services as $serviceId => $data) {
            // todo необходимо устанавливать security context в каждый handler
            $class = $container->getDefinition($serviceId)->getClass();
            $types[$class::getObjectClass()] = new Reference($serviceId);
        }

        $definition = $container->getDefinition('perfico_crm.permission_manager');
        $definition->addMethodCall('setHandlers', array($types));
    }
} 