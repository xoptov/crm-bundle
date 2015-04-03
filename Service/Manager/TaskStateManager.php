<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\EntityRepository;
use Perfico\CoreBundle\Entity\TaskState;

class TaskStateManager extends GenericManager
{
    /**
     * @return TaskState[]
     * @todo need refactoring this method
     */
    public function getAccountTaskStates()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:TaskState');

        return $repo->createQueryBuilder('ds')
            ->where('ds.account = :account')
            ->setParameter('account', $this->getCurrentAccount())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return TaskState
     */
    public function create()
    {
        $taskState = new TaskState();
        $taskState->setAccount($this->getCurrentAccount());

        return $taskState;
    }
} 