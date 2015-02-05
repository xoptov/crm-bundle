<?php

namespace Perfico\DosalesBundle\Entity;

interface PaymentInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @param string $note
     * @return PaymentInterface
     */
    public function setNote($note);

    /**
     * @return string
     */
    public function getNote();

    /**
     * @param DealInterface $deal
     * @return PaymentInterface
     */
    public function setDeal(DealInterface $deal);

    /**
     * @return DealInterface
     */
    public function getDeal();

    /**
     * @param float $amount
     * @return PaymentInterface
     */
    public function setAmount($amount);

    /**
     * @return float
     */
    public function getAmount();

    /**
     * @param AccountInterface $account
     * @return PaymentInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
} 