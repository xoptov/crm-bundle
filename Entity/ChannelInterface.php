<?php

namespace Perfico\CRMBundle\Entity;

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
     * @param string $link
     * @return ChannelInterface
     */
    public function setExternalLink($link);

    /**
     * @return string
     */
    public function getExternalLink();

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