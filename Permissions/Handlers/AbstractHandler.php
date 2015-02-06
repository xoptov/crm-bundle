<?php

namespace Perfico\DosalesBundle\Permissions\Handlers;

use Perfico\DosalesBundle\Entity\UserInterface;
use Perfico\DosalesBundle\Exception\InappropriateClassException;
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
     * @return array
     * @throws InappropriateClassException
     */
    public function permissions($object)
    {
        if (get_class($object) != $this->objectClass) {
            throw new InappropriateClassException('Inappropriate class of object');
        }

        /** Retrieve user from security context */
        $this->user = $this->securityContext->getToken()->getUser();

        $permission = [
            'view' => false,
            'edit' => false,
            'remove' => false,
            'add' => false
        ];

        if ($this->securityContext->isGranted($this->rolePrefix . 'VIEW_ALL'))
            $permission['view'] = true;

        if ($this->securityContext->isGranted($this->rolePrefix . 'VIEW_OWN') && $object->getUser() == $this->user)
            $permission['view'] = true;

        $permission['edit'] = $this->securityContext->isGranted($this->rolePrefix . 'EDIT');
        $permission['remove'] = $this->securityContext->isGranted($this->rolePrefix . 'REMOVE');
        $permission['add'] = $this->securityContext->isGranted($this->rolePrefix . 'ADD');

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