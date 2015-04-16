<?php

namespace Perfico\CRMBundle\Search;

use Perfico\CRMBundle\Entity\AccountInterface;

final class ChannelCondition implements ChannelConditionInterface
{
    /** @var AccountInterface */
    private $account;

    /** @var string */
    private $treeName;

    /** @var string */
    private $treeNumber;

    /**
     * @param string $name
     * @return ChannelCondition
     */
    public function setTreeName($name)
    {
        $this->treeName = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTreeName()
    {
        return $this->treeName;
    }

    /**
     * @param string $number
     * @return ChannelCondition
     */
    public function setTreeNumber($number)
    {
        $this->treeNumber = $number;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTreeNumber()
    {
        return $this->treeNumber;
    }

    /**
     * @param AccountInterface $account
     * @return ChannelCondition
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