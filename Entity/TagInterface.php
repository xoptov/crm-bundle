<?php

namespace Perfico\CRMBundle\Entity;

interface TagInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $name
     * @return TagInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return ClientInterface[]
     */
    public function getClients();

    /**
     * @param AccountInterface $account
     * @return TagInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
} 