<?php

namespace Perfico\CRMBundle\Entity;

interface ProductInterface
{
    public function onCreate();

    public function onUpdate();
    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $name
     * @return ProductInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @param float $amount
     * @return ProductInterface
     */
    public function setAmount($amount);

    /**
     * @return float
     */
    public function getAmount();

    /**
     * @param AccountInterface $account
     * @return ProductInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();

    /**
     * @return ProductInterface[]
     */
    public function getChildren();

    /**
     * @param ProductInterface $parent
     * @return ProductInterface
     */
    public function setParent(ProductInterface $parent);

    /**
     * @return ProductInterface
     */
    public function getParent();

    /**
     * @param string $sku
     * @return ProductInterface
     */
    public function setSku($sku);

    /**
     * @return string
     */
    public function getSku();

    /**
     * @return DealInterface[]
     */
    public function getDeals();
}