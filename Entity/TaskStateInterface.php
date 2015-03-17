<?php

namespace Perfico\CRMBundle\Entity;

interface TaskStateInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $name
     * @return TaskStateInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $account
     * @return TaskStateInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
}