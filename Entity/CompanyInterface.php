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
     * @param string $inn
     * @return CompanyInterface
     */
    public function setInn($inn);

    /**
     * @return string
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
     * @param AccountInterface $account
     * @return CompanyInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
} 