<?php

namespace Perfico\DosalesBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class PermissionCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $types = [];
        $services = $container->findTaggedServiceIds('perfico_crm.permission_handler');
        foreach ($services as $serviceId => $data) {
            $definition = $container->getDefinition($serviceId);
            $tag = $definition->getTag('perfico_crm.permission_handler');

            // Setting role prefix
            if (!isset($tag[0]) || !isset($tag[0]['role_prefix']))
                throw new InvalidConfigurationException('Not found tag attribute role_prefix');

            $definition->addMethodCall('setRolePrefix', array($tag[0]['role_prefix']));

            // Setting SecurityContext
            $definition->addMethodCall('setSecurityContext', array($container->getDefinition('security.context')));

            // Setting object class
            if (!isset($tag[0]) || !isset($tag[0]['object_class']))
                throw new InvalidConfigurationException('Not found tag attribute object_class');

            $definition->addMethodCall('setObjectClass', array($tag[0]['object_class']));

            /** @var string $class */
            $types[$tag[0]['object_class']] = new Reference($serviceId);
        }

        $definition = $container->getDefinition('perfico_dosales.permission_manager');
        $definition->addMethodCall('setHandlers', array($types));
    }
} 