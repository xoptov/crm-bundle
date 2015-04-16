<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Channel;
use Perfico\CRMBundle\Entity\ChannelInterface;
use Doctrine\ORM\EntityRepository;
use Perfico\CRMBundle\Search\ChannelConditionInterface;
use Perfico\CRMBundle\Service\Search\PrepareAccountTrait;
use Doctrine\ORM\QueryBuilder;

class ChannelManager extends GenericManager
{
    use PrepareAccountTrait;

    /** @var QueryBuilder */
    protected $qb;

    /**
     * @return ChannelInterface[]
     * @todo need refactoring this method
     */
    public function getAccountChannels()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Channel');

        return $repo->createQueryBuilder('c')
            ->where('c.account = :account')
            ->setParameter('account', $this->getCurrentAccount())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Channel
     */
    public function create()
    {
        $channel = new Channel();
        $channel->setAccount($this->getCurrentAccount());

        return $channel;
    }

    /**
     * @param ChannelConditionInterface $condition
     * @return ChannelInterface
     */
    public function searchOne(ChannelConditionInterface $condition)
    {
        $this->qb = $this->em->createQueryBuilder();
        $this->qb->select('ch')->from('CoreBundle:Channel', 'ch');
        $this->initQueryBuilder($condition);

        return $this->qb->getQuery()->getOneOrNullResult();
    }

    protected function initQueryBuilder(ChannelConditionInterface $condition)
    {
        $this->prepareAccountCondition($this->qb, $condition, 'ch');
        $this->prepareTreeCondition($condition);
    }

    protected function prepareTreeCondition(ChannelConditionInterface $condition)
    {
        if ($condition->getTreeName() && $condition->getTreeNumber()) {
            $orX = $this->qb->expr()->orX();
            $orX->add($this->qb->expr()->like('ch.externalLink', $this->qb->expr()->literal('%'. $condition->getTreeNumber() .'%')));
            $orX->add($this->qb->expr()->like('ch.externalLink', $this->qb->expr()->literal('%'. $condition->getTreeName() .'%')));
            $this->qb->andWhere($orX);
        } else if ($condition->getTreeName()) {
            $this->qb->andWhere('ch.externalLink LIKE :tree_name')->setParameter('tree_name', '%' . $condition->getTreeName() . '%');
        } else if ($condition->getTreeNumber()) {
            $this->qb->andWhere('ch.externalLink LIKE :tree_number')->setParameter('tree_number', '%' . $condition->getTreeNumber() . '%');
        }
    }
} 