<?php

namespace Perfico\CRMBundle\Entity;

interface ContactInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param UserInterface $user
     * @return ContactInterface
     */
    public function setUser(UserInterface $user);

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @param string $phone
     * @return ContactInterface
     */
    public function setPhone($phone);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $sip
     * @return ContactInterface
     */
    public function setSip($sip);

    /**
     * @return string
     */
    public function getSip();

    /**
     * @param string $skype
     * @return ContactInterface
     */
    public function setSkype($skype);

    /**
     * @return string
     */
    public function getSkype();

    /**
     * @param AccountInterface $account
     * @return ContactInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
} 