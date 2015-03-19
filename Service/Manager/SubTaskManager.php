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
    public function getSubTask()
    {
        return $this->em->getRepository('CoreBundle:SubTask')
            ->findAll();
    }

    /**
     * @return SubTask[]|array
     */
    public function getSubTaskForTask(Task $task)
    {
        $repo = $this->em->getRepository('CoreBundle:SubTask');

        return $repo->createQueryBuilder('ct')
            ->where('ct.taskId = :task')
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

        return $subTask;
    }
}