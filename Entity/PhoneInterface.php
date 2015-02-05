<?php

namespace Perfico\DosalesBundle\Entity;

interface PhoneInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $number
     * @return PhoneInterface
     */
    public function setNumber($number);

    /**
     * @return string
     */
    public function getNumber();

    /**
     * @param ClientInterface $client
     * @return PhoneInterface
     */
    public function setClient(ClientInterface $client);

    /**
     * @return ClientInterface
     */
    public function getClient();

    /**
     * @param AccountInterface $account
     * @return PhoneInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
} 