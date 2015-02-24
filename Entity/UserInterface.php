<?php

namespace Perfico\CRMBundle\Entity;

interface UserInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $firstName
     * @return UserInterface
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param string $lastName
     * @return UserInterface
     */
    public function setLastName($lastName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param string $middleName
     * @return UserInterface
     */
    public function setMiddleName($middleName);

    /**
     * @return string
     */
    public function getMiddleName();

    /**
     * @param string $phone
     * @return UserInterface
     */
    public function setPhone($phone);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param DealInterface[] $deals
     * @return mixed
     */
    public function setDeals($deals);

    /**
     * @return DealInterface[]
     */
    public function getDeals();

    /**
     * @param AccountInterface $account
     * @return UserInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();

    /**
     * @param $groups
     * @return UserInterface
     */
    public function setGroups($groups);

    public function getGroups();
} 