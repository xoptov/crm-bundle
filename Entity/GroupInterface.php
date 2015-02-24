<?php

namespace Perfico\CRMBundle\Entity;

interface GroupInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param AccountInterface $account
     * @return GroupInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
} 