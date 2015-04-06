<?php

namespace Perfico\CRMBundle\Entity;

abstract class Channel implements ChannelInterface
{
    /** @var integer */
    protected $id;

    /** @var string */
    protected $name;

    /**
     * @var string
     */
    protected $externalLink;

    /** @var AccountInterface */
    protected $account;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setExternalLink($link)
    {
        $this->externalLink = $link;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExternalLink()
    {
        return $this->externalLink;
    }

    /**
     * {@inheritdoc}
     */
    public function setAccount(AccountInterface $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccount()
    {
        return $this->account;
    }
} 