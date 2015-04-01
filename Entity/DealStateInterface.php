<?php

namespace Perfico\CRMBundle\Entity;

interface DealStateInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param DealStateInterface $acceptor
     * @return DealStateInterface
     */
    public function setAcceptor(DealStateInterface $acceptor);

    /**
     * @return DealStateInterface
     */
    public function getAcceptor();

    /**
     * @param string $name
     * @return DealStateInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $icon
     * @return DealStateInterface
     */
    public function setIcon($icon);

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @return DealInterface[]
     */
    public function getDeals();

    /**
     * @param AccountInterface $account
     * @return DealStateInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();

    /**
     * @param boolean $value
     * @return DealStateInterface
     */
    public function setRequirePayments($value);

    /**
     * @return bool
     */
    public function hasRequirePayments();
} 