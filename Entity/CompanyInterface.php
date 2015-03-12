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
     * @param integer $inn
     * @return CompanyInterface
     */
    public function setInn($inn);

    /**
     * @return integer
     */
    public function getInn();

    /**
     * @param string $phone
     * @return CompanyInterface
     */
    public function setPhone($phone);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $details
     * @return CompanyInterface
     */
    public function setDetails($details);

    /**
     * @return string
     */
    public function getDetails();

    /**
     * @param UserInterface $user
     * @return CompanyInterface
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();

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