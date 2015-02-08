<?php

namespace Perfico\CRMBundle\Permissions;

use Perfico\CRMBundle\Permissions\Handlers\HandlerInterface;
use Symfony\Component\Security\Core\SecurityContext;

class PermissionManager
{
    /**
     * @var HandlerInterface[]
     */
    protected $handlers;

    /**
     * @var SecurityContext
     */
    private $securityContext;

    /**
     * @param SecurityContext $securityContext
     */
    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param HandlerInterface[] $handlers
     */
    public function setHandlers($handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @param $object
     * @return array
     */
    public function getPermissions($object)
    {
        $class = get_class($object);
        if (array_key_exists($class, $this->handlers)) {
            return ['_permissions' => $this->handlers[$class]->permissions($object)];
        }
        return ['_permissions' => []];
    }

    /**
     * @param array $roles
     * @return bool
     */
    public function checkAnyRole(array $roles)
    {
        if($this->securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        foreach ($roles as $role) {
            if ($this->securityContext->isGranted($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $object
     * @param $action
     * @return bool
     */
    public function checkObjectRole($object, $action)
    {
        if (!$object) {
            return true;
        }
        $class = get_class($object);
        if (array_key_exists($class, $this->handlers)) {
            return $this->handlers[$class]->checkAction($object, $action);
        }
        return false;
    }

}