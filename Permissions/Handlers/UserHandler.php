<?php

namespace Perfico\CRMBundle\Permissions\Handlers;

class UserHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    public function permissions($object, $context)
    {
        $permissions = parent::permissions($object, $context);

        $permissions['activities']['view'] = false;
        $permissions['channels']['view'] = false;
        $permissions['clients']['view'] = false;
        $permissions['companies']['view'] = false;
        $permissions['customFields']['view'] = false;
        $permissions['deals']['view'] = false;
        $permissions['dealStates']['view'] = false;
        $permissions['groups']['view'] = false;
        $permissions['payments']['view'] = false;
        $permissions['phones']['view'] = false;
        $permissions['products']['view'] = false;
        $permissions['tags']['view'] = false;

        /** Activity permissions */
        if ($this->securityContext->isGranted(['ROLE_ACTIVITY_VIEW_ALL', 'ROLE_ACTIVITY_VIEW_OWN']))
            $permissions['activities']['view'] = true;

        $permissions['activities']['edit'] = $this->securityContext->isGranted('ROLE_ACTIVITY_EDIT');
        $permissions['activities']['remove'] = $this->securityContext->isGranted('ROLE_ACTIVITY_REMOVE');
        $permissions['activities']['add'] = $this->securityContext->isGranted('ROLE_ACTIVITY_ADD');

        /** Channel permissions */
        if ($this->securityContext->isGranted('ROLE_CHANNEL_VIEW_ALL'))
            $permissions['channels']['view'] = true;

        $permissions['channels']['edit'] = $this->securityContext->isGranted('ROLE_CHANNEL_EDIT');
        $permissions['channels']['remove'] = $this->securityContext->isGranted('ROLE_CHANNEL_REMOVE');
        $permissions['channels']['add'] = $this->securityContext->isGranted('ROLE_CHANNEL_ADD');

        /** Client permissions */
        if ($this->securityContext->isGranted(['ROLE_CLIENT_VIEW_ALL', 'ROLE_CLIENT_VIEW_OWN']))
            $permissions['clients']['view'] = true;

        $permissions['clients']['edit'] = $this->securityContext->isGranted('ROLE_CLIENT_EDIT');
        $permissions['clients']['remove'] = $this->securityContext->isGranted('ROLE_CLIENT_REMOVE');
        $permissions['clients']['add'] = $this->securityContext->isGranted('ROLE_CLIENT_ADD');

        /** Company permissions */
        if ($this->securityContext->isGranted('ROLE_COMPANY_VIEW_ALL'))
            $permissions['companies']['view'] = true;

        $permissions['companies']['edit'] = $this->securityContext->isGranted('ROLE_COMPANY_EDIT');
        $permissions['companies']['remove'] = $this->securityContext->isGranted('ROLE_COMPANY_REMOVE');
        $permissions['companies']['add'] = $this->securityContext->isGranted('ROLE_COMPANY_ADD');

        /** Custom field permissions */
        if ($this->securityContext->isGranted('ROLE_CUSTOM_FIELD_VIEW_ALL'))
            $permissions['customFields']['view'] = true;

        $permissions['customFields']['edit'] = $this->securityContext->isGranted('ROLE_CUSTOM_FIELD_EDIT');
        $permissions['customFields']['remove'] = $this->securityContext->isGranted('ROLE_CUSTOM_FIELD_REMOVE');
        $permissions['customFields']['add'] = $this->securityContext->isGranted('ROLE_CUSTOM_FIELD_ADD');

        /** Deal permissions */
        if ($this->securityContext->isGranted(['ROLE_DEAL_VIEW_ALL', 'ROLE_DEAL_VIEW_OWN']))
            $permissions['deals']['view'] = true;

        $permissions['deals']['edit'] = $this->securityContext->isGranted('ROLE_DEAL_EDIT');
        $permissions['deals']['remove'] = $this->securityContext->isGranted('ROLE_DEAL_REMOVE');
        $permissions['deals']['add'] = $this->securityContext->isGranted('ROLE_DEAL_ADD');

        /** Deal state permissions */
        if ($this->securityContext->isGranted(['ROLE_DEAL_STATE_VIEW_ALL', 'ROLE_DEAL_STATE_VIEW_OWN']))
            $permissions['dealStates']['view'] = true;

        $permissions['dealStates']['edit'] = $this->securityContext->isGranted('ROLE_DEAL_STATE_EDIT');
        $permissions['dealStates']['remove'] = $this->securityContext->isGranted('ROLE_DEAL_STATE_REMOVE');
        $permissions['dealStates']['add'] = $this->securityContext->isGranted('ROLE_DEAL_STATE_ADD');

        /** Group permissions */
        if ($this->securityContext->isGranted('ROLE_GROUP_VIEW_ALL'))
            $permissions['groups']['view'] = true;

        $permissions['groups']['edit'] = $this->securityContext->isGranted('ROLE_GROUP_EDIT');
        $permissions['groups']['remove'] = $this->securityContext->isGranted('ROLE_GROUP_REMOVE');
        $permissions['groups']['add'] = $this->securityContext->isGranted('ROLE_GROUP_ADD');

        /** Payment permissions */
        if ($this->securityContext->isGranted(['ROLE_PAYMENT_VIEW_ALL', 'ROLE_PAYMENT_VIEW_OWN']))
            $permissions['payments']['view'] = true;

        $permissions['payments']['edit'] = $this->securityContext->isGranted('ROLE_PAYMENT_EDIT');
        $permissions['payments']['remove'] = $this->securityContext->isGranted('ROLE_PAYMENT_REMOVE');
        $permissions['payments']['add'] = $this->securityContext->isGranted('ROLE_PAYMENT_ADD');

        /** Phone permissions */
        if ($this->securityContext->isGranted(['ROLE_PHONE_VIEW_ALL', 'ROLE_PHONE_VIEW_OWN']))
            $permissions['phones']['view'] = true;

        $permissions['phones']['edit'] = $this->securityContext->isGranted('ROLE_PHONE_EDIT');
        $permissions['phones']['remove'] = $this->securityContext->isGranted('ROLE_PHONE_REMOVE');
        $permissions['phones']['add'] = $this->securityContext->isGranted('ROLE_PHONE_ADD');

        /** Product permissions */
        if ($this->securityContext->isGranted('ROLE_PRODUCT_VIEW_ALL'))
            $permissions['products']['view'] = true;

        $permissions['products']['edit'] = $this->securityContext->isGranted('ROLE_PRODUCT_EDIT');
        $permissions['products']['remove'] = $this->securityContext->isGranted('ROLE_PRODUCT_REMOVE');
        $permissions['products']['add'] = $this->securityContext->isGranted('ROLE_PRODUCT_ADD');

        /** Tag permissions */
        if ($this->securityContext->isGranted(['ROLE_TAG_VIEW_ALL', 'ROLE_TAG_VIEW_OWN']))
            $permissions['tags']['view'] = true;

        $permissions['tags']['edit'] = $this->securityContext->isGranted('ROLE_TAG_EDIT');
        $permissions['tags']['remove'] = $this->securityContext->isGranted('ROLE_TAG_REMOVE');
        $permissions['tags']['add'] = $this->securityContext->isGranted('ROLE_TAG_ADD');


        return $permissions;
    }
} 