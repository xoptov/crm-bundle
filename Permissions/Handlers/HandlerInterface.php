<?php

namespace Perfico\DosalesBundle\Permissions\Handlers;

use Symfony\Component\Security\Core\SecurityContextInterface;

interface HandlerInterface
{
    /**
     * @param string $prefix
     */
    public function setRolePrefix($prefix);

    /**
     * @param SecurityContextInterface $securityContext
     */
    public function setSecurityContext(SecurityContextInterface $securityContext);

    /**
     * @param string $class
     */
    public function setObjectClass($class);

    /**
     * Must return array of permissions by object:
     *  edit => true
     *  delete => false
     *  deals => true
     *
     * @param $object
     * @return array
     */
    public function permissions($object);

    /**
     * Action: VIEW, EDIT, REMOVE, ADD
     *
     * @param $object
     * @param $action
     * @return boolean
     */
    public function checkAction($object, $action);
} 