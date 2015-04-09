<?php

namespace Perfico\CRMBundle\Transformer\Converter;

use Perfico\CRMBundle\Entity\Group;
use Perfico\CRMBundle\Service\Manager\AccountManager;

class GroupConverter extends AbstractEntityConverter
{
    /** @var AccountManager */
    protected $accountManager;

    public function setAccountManager(AccountManager $accountManager)
    {
        $this->accountManager = $accountManager;
    }

    public function reverseConvert($object)
    {
        if ($object instanceof Group) {
            if ($object->getAccount() == $this->accountManager->getCurrentAccount()) {
                return [
                    'id' => $object->getId(),
                    'name' => $object->getName(),
                    'roles' => $object->getRoles()
                ];
            }
        }

        return null;
    }
} 