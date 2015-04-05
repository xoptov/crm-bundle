<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\CustomField;

class CustomFieldManager extends GenericManager
{
    public function create()
    {
        $customField = new CustomField();
        $customField->setAccount($this->getCurrentAccount());

        return $customField;
    }

    public function getAccountCustomFields()
    {
        return $this->em->getRepository('CoreBundle:CustomField')
            ->findBy(array('account' => $this->getCurrentAccount()));
    }
} 