<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Doctrine\ORM\EntityRepository;

class TaskManager extends GenericManager
{
    /**
     * @param null $onlyForUser
     * @return Task[]
     * @todo need refactoring this method
     */
    public function getAccountTask($onlyForUser = null)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Task');

        $builder = $repo->createQueryBuilder('c')
            ->where('c.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
        ;

        return $builder
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Task
     */
    public function create()
    {
        $task = new Task();
        $task->setAccount($this->accountManager->getCurrentAccount());

        if(!$this->securityContext->getToken() instanceof AnonymousToken ) {
            $task->setUser($this->securityContext->getToken()->getUser());
        }

        return $task;
    }

}