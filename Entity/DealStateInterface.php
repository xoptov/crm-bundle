<?php

namespace Perfico\CRMBundle\Entity;


interface DealStateInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param DealStateInterface $heir
     * @return DealStateInterface
     */
    public function setHeir(DealStateInterface $heir);

    /**
     * @return DealStateInterface
     */
    public function getHeir();

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
} 