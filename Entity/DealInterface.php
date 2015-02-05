<?php

namespace Perfico\DosalesBundle\Entity;

interface DealInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param float $amount
     * @return DealInterface
     */
    public function setAmount($amount);

    /**
     * @return float
     */
    public function getAmount();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param string $note
     * @return DealInterface
     */
    public function setNote($note);

    /**
     * @return string
     */
    public function getNote();

    /**
     * @param ClientInterface $client
     * @return DealInterface
     */
    public function setClient(ClientInterface $client);

    /**
     * @return DealInterface
     */
    public function getClient();

    /**
     * @param DealStateInterface $state
     * @return DealInterface
     */
    public function setState(DealStateInterface $state);

    /**
     * @return string
     */
    public function getState();

    /**
     * @return PaymentInterface[]
     */
    public function getPayments();

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param AccountInterface $account
     * @return DealInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
} 