<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\EntityRepository;
use Perfico\CoreBundle\Entity\SubTask;
use Perfico\CoreBundle\Entity\Task;

class SubTaskManager extends GenericManager
{
    /**
     * @return SubTask[]|array
     */
    public function getAccountSubTask()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:SubTask');

        return $repo->createQueryBuilder('st')
            ->where('st.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return SubTask[]|array
     */
    public function getSubTaskForTask(Task $task)
    {
        $repo = $this->em->getRepository('CoreBundle:SubTask');

        return $repo->createQueryBuilder('ct')
            ->where('ct.task = :task')
            ->setParameter('task', $task)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return SubTask
     */
    public function create()
    {
        $subTask = new SubTask();
        $subTask->setAccount($this->accountManager->getCurrentAccount());

        return $subTask;
    }
}