<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\TaskType;
use Doctrine\ORM\EntityRepository;

class TaskTypeManager extends GenericManager
{
    /**
     * @return TaskType[]
     * @todo need refactoring this method
     */
    public function getAccountTaskTypes()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:TaskType');

        return $repo->createQueryBuilder('tt')
            ->where('tt.account = :account')
            ->setParameter('account', $this->getCurrentAccount())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return TaskType
     */
    public function create()
    {
        $taskType = new TaskType();
        $taskType->setAccount($this->getCurrentAccount());

        return $taskType;
    }

}