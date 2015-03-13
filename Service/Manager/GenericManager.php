<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Model\PagenatedInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

abstract class GenericManager implements GenericManagerInterface
{
    /** @var EntityManagerInterface */
    protected $em;

    /** @var AccountManager */
    protected $accountManager;

    /** @var SecurityContextInterface */
    protected $securityContext;

    /**
     * @param EntityManagerInterface $em
     * @param AccountManager $accountManager
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(EntityManagerInterface $em, AccountManager $accountManager, SecurityContextInterface $securityContext)
    {
        $this->em = $em;
        $this->accountManager = $accountManager;
        $this->securityContext = $securityContext;
    }

    /**
     * @param mixed $entity
     */
    public function update($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @param mixed $entity
     */
    public function remove($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }


} 