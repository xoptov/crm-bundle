<?php

namespace Perfico\CRMBundle\Permissions\Handlers;

use Perfico\CoreBundle\Entity\Deal;

class DealHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    public function permissions($object, $context)
    {
        $permissions = parent::permissions($object, $context);
        /** @var Deal $object */

        $permissions['payments']['view'] = false;

        /** Payments permissions */
        if ($this->securityContext->isGranted('ROLE_PAYMENT_VIEW_ALL'))
            $permissions['payments']['view'] = true;

        if ($this->securityContext->isGranted('ROLE_PAYMENT_VIEW_OWN') && $object->getUser() == $this->user)
            $permissions['payments']['view'] = true;

        $permissions['payments']['add'] = $this->securityContext->isGranted('ROLE_PAYMENT_ADD');
        $permissions['payments']['edit'] = $this->securityContext->isGranted('ROLE_PAYMENT_EDIT');
        $permissions['payments']['remove'] = $this->securityContext->isGranted('ROLE_PAYMENT_REMOVE');

        return $permissions;
    }
}