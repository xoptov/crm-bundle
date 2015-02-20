<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\EntityRepository;
use Perfico\CoreBundle\Entity\DealState;

class DealStateManager extends GenericManager
{
    /**
     * @return DealState[]
     * @todo need refactoring this method
     */
    public function getAccountDealStates()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:DealState');

        return $repo->createQueryBuilder('ds')
            ->where('ds.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return DealState
     */
    public function create()
    {
        $dealState = new DealState();
        $dealState->setAccount($this->accountManager->getCurrentAccount());

        return $dealState;
    }
} 