<?php

namespace Perfico\CRMBundle\Permissions\Handlers;

class ClientHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    public function permissions($object, $context)
    {
        $permissions = parent::permissions($object, $context);

        /** Initialize permissions */
        $permissions['deals']['view'] = false;
        $permissions['payments']['view'] = false;
        $permissions['activities']['view'] = false;
        $permissions['phones']['view'] = false;

        /** Deal permissions */
        if ($this->securityContext->isGranted('ROLE_DEAL_VIEW_ALL'))
            $permissions['deals']['view'] = true;

        if ($this->securityContext->isGranted('ROLE_DEAL_VIEW_OWN') && $object->getUser() == $this->user)
            $permissions['deals']['view'] = true;

        $permissions['deals']['edit'] = $this->securityContext->isGranted('ROLE_DEAL_EDIT');
        $permissions['deals']['remove'] = $this->securityContext->isGranted('ROLE_DEAL_REMOVE');
        $permissions['deals']['add'] = $this->securityContext->isGranted('ROLE_DEAL_ADD');

        /** Payment permissions */
        if ($this->securityContext->isGranted('ROLE_PAYMENT_VIEW_ALL'))
            $permissions['payments']['view'] = true;

        if ($this->securityContext->isGranted('ROLE_PAYMENT_VIEW_OWN') && $object->getUser() == $this->user)
            $permissions['payments']['view'] = true;

        $permissions['payments']['edit'] = $this->securityContext->isGranted('ROLE_PAYMENT_EDIT');
        $permissions['payments']['remove'] = $this->securityContext->isGranted('ROLE_PAYMENT_REMOVE');
        $permissions['payments']['add'] = $this->securityContext->isGranted('ROLE_PAYMENT_ADD');

        /** Activity permissions */
        if ($this->securityContext->isGranted('ROLE_ACTIVITY_VIEW_ALL'))
            $permissions['activities']['view'] = true;

        if ($this->securityContext->isGranted('ROLE_ACTIVITY_VIEW_OWN') && $object->getUser() == $this->user)
            $permissions['activities']['view'] = true;

        $permissions['activities']['add'] = $this->securityContext->isGranted('ROLE_ACTIVITY_ADD');
        $permissions['activities']['edit'] = $this->securityContext->isGranted('ROLE_ACTIVITY_EDIT');
        $permissions['activities']['remove'] = $this->securityContext->isGranted('ROLE_ACTIVITY_REMOVE');

        /** Phone permissions */

        if ($this->securityContext->isGranted('ROLE_PHONE_VIEW_ALL'))
            $permissions['phones']['view'] = true;

        if ($this->securityContext->isGranted('ROLE_PHONE_VIEW_OWN') && $object->getUser() == $this->user)
            $permissions['phones']['view'] = true;

        $permissions['phones']['add'] = $this->securityContext->isGranted('ROLE_PHONE_ADD');
        $permissions['phones']['edit'] = $this->securityContext->isGranted('ROLE_PHONE_EDIT');
        $permissions['phones']['remove'] = $this->securityContext->isGranted('ROLE_PHONE_REMOVE');

        return $permissions;
    }
}