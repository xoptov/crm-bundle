<?php

namespace Perfico\CRMBundle\Entity;

interface CompanyInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $name
     * @return CompanyInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param AccountInterface $account
     * @return CompanyInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
} 