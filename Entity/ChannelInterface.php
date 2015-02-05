<?php

namespace Perfico\DosalesBundle\Entity;

interface ChannelInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $name
     * @return ChannelInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param AccountInterface $account
     * @return ChannelInterface
     */
    public function setAccount(AccountInterface $account);

    /**
     * @return AccountInterface
     */
    public function getAccount();
} 