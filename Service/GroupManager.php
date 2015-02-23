<?php

namespace Perfico\CRMBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\GroupManager as BaseManager;
use Perfico\CRMBundle\Service\Manager\AccountManager;

/**
 * Class GroupManager
 * @package Perfico\CRMBundle\Service
 */
class GroupManager extends BaseManager {

    protected $accountManager;

    /**
     * @param ObjectManager $om
     * @param $class
     * @param AccountManager $accountManager
     */
    public function __construct(ObjectManager $om, $class, AccountManager $accountManager)
    {
        parent::__construct($om, $class);
        $this->accontManager = $accountManager;
    }

    /**
     * {@inheritDoc}
     */
    public function findGroups()
    {
        return $this->repository->findBy(['account' => $this->accontManager->getCurrentAccount()]);
    }
}