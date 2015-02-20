<?php

namespace Perfico\CRMBundle\Entity;

interface CustomFieldInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $name
     * @return CustomFieldInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param int $number
     * @return CustomFieldInterface
     */
    public function setNumber($number);

    /**
     * @return int
     */
    public function getNumber();

    /**
     * @param AccountInterface $account
     * @return CustomFieldInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return CustomFieldInterface
     */
    public function getAccount();
} 