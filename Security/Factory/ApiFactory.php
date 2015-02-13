<?php


namespace Perfico\CRMBundle\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class ApiFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $key = $container->getParameter('secret');

        $providerId = 'security.authentication.provider.api.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('perfico_crm.auth_provider'))
            ->replaceArgument(0, new Reference($userProvider))
            ->replaceArgument(1, $providerId)
            ->replaceArgument(2, $key);

        $listenerId = 'security.authentication.listener.api.'.$id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('perfico_crm.auth_listener'));
        $listener
            ->replaceArgument(3, $providerId)
            ->replaceArgument(4, $key)
        ;

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'api_factory';
    }

    public function addConfiguration(NodeDefinition $builder)
    {
    }
} 