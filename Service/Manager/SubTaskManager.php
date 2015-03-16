<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\EntityRepository;
use Perfico\CoreBundle\Entity\SubTask;

class SubTaskManager extends GenericManager
{
    /**
     * @return SubTask
     */
    public function create()
    {
        $subTask = new SubTask();

        return $subTask;
    }
}