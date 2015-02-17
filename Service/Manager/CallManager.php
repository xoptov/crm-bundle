<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Call;

class CallManager extends GenericManager
{
    public function create()
    {

    }

    /**
     * @return Call[]|array
     */
    public function getCalls()
    {
        return $this->em->getRepository('CoreBundle:Call')
            ->findBy(array('account' => $this->accountManager->getCurrentAccount()));
    }
}