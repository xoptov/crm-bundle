<?php

namespace Perfico\CRMBundle;

use Perfico\CRMBundle\Security\Factory\ApiFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Perfico\CRMBundle\DependencyInjection\Compiler\PermissionCompilerPass;

class PerficoCRMBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new PermissionCompilerPass());
        $container->getExtension('security')->addSecurityListenerFactory(new ApiFactory());
    }
}
