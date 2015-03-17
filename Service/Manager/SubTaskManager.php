<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\EntityRepository;
use Perfico\CoreBundle\Entity\SubTask;

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
     * @return SubTask
     */
    public function create()
    {
        $subTask = new SubTask();

        return $subTask;
    }
}