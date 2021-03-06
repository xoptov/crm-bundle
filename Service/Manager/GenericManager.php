<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Perfico\CRMBundle\Entity\AccountInterface;
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
     * @param boolean $flush
     */
    public function update($entity, $flush = true)
    {
        $this->em->persist($entity);

        if ($flush) {
            $this->em->flush();
        }
    }

    /**
     * @param mixed $entity
     */
    public function remove($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * @return AccountInterface
     */
    public function getCurrentAccount()
    {
        return $this->accountManager->getCurrentAccount();
    }

} 