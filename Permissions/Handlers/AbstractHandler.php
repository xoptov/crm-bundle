<?php

namespace Perfico\CRMBundle\Permissions\Handlers;

use Perfico\CRMBundle\Entity\UserInterface;
use Perfico\CRMBundle\Exception\InappropriateClassException;
use Symfony\Component\Security\Core\SecurityContextInterface;

abstract class AbstractHandler implements HandlerInterface
{
    /** @var UserInterface */
    protected $user;

    /** @var string */
    protected $rolePrefix;

    /** @var SecurityContextInterface */
    protected $securityContext;

    /** @var string */
    protected $objectClass;

    /**
     * @param string $rolePrefix
     */
    public function setRolePrefix($rolePrefix)
    {
        $this->rolePrefix = $rolePrefix;
    }

    /**
     * @param SecurityContextInterface $securityContext
     */
    public function setSecurityContext(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param string $class
     */
    public function setObjectClass($class)
    {
        $this->objectClass = $class;
    }

    /**
     * @param $object
     * @param $context
     * @return array
     * @throws InappropriateClassException
     */
    public function permissions($object, $context)
    {
        /**
         * Object can be regular object or Doctrine Proxy object
         */
        if (!$object instanceof $this->objectClass) {
            throw new InappropriateClassException('Inappropriate class of object');
        }

        /** Retrieve user from security context */
        $this->user = $this->securityContext->getToken()->getUser();

        $permission = [
            $context => [
                'view' => false,
                'edit' => false,
                'remove' => false,
                'add' => false
            ]
        ];

        if ($this->securityContext->isGranted($this->rolePrefix . 'VIEW_ALL'))
            $permission[$context]['view'] = true;

        if (method_exists($object, 'getUser')) {
            if ($this->securityContext->isGranted($this->rolePrefix . 'VIEW_OWN') && $object->getUser() == $this->user)
                $permission[$context]['view'] = true;
        }

        $permission[$context]['edit'] = $this->securityContext->isGranted($this->rolePrefix . 'EDIT');
        $permission[$context]['remove'] = $this->securityContext->isGranted($this->rolePrefix . 'REMOVE');
        $permission[$context]['add'] = $this->securityContext->isGranted($this->rolePrefix . 'ADD');

        return $permission;
    }

    /**
     * @param string $object
     * @param string $action
     * @return bool
     * @throws InappropriateClassException
     */
    public function checkAction($object, $action)
    {
        if (get_class($object) != $this->objectClass) {
            throw new InappropriateClassException('Inappropriate class of object');
        }

        $this->user = $this->securityContext->getToken()->getUser();

        if ($this->securityContext->isGranted($this->rolePrefix . $action))
            return true;

        if ($this->securityContext->isGranted($this->rolePrefix . $action . '_ALL'))
            return true;

        if ($this->securityContext->isGranted($this->rolePrefix . $action . '_OWN') && $object->getUser() == $this->user)
            return true;

        return false;
    }
} 