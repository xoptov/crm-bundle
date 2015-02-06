<?php

namespace Perfico\DosalesBundle\Permissions\Handlers;


use Symfony\Component\Security\Core\User\UserInterface;

interface HandlerInterface
{
    /**
     * Must return className of object.
     * @return string
     */
    public static function getObjectClass();

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