<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Deal;
use Doctrine\ORM\EntityRepository;

class DealManager extends GenericManager
{
    /**
     * @return Deal[]
     * @todo need refactoring this method
     */
    public function getAccountDeals()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Deal');

        return $repo->createQueryBuilder('d')
            ->where('d.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
            ->getQuery()
            ->getResult();
    }

    /**
     * @todo need refactoring this method
     */
    public function getQueryBuilder($deal)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Payment');

        return $repo->createQueryBuilder('p')
                    ->where('p.deal = :deal')
                    ->setParameter('deal', $deal);
    }

    /**
     * @todo need refactoring this method
     */
    public function getDealPayments(Deal $deal, $page, $limit)
    {
        $builderItems = $this->getQueryBuilder($deal);
        $builderCount = $this->getQueryBuilder($deal);

        $items = $builderItems
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        $count = $builderCount
            ->select('count(p)')
            ->getQuery()
            ->getSingleScalarResult();

        return [
            'items' => $items,
            'count' => $count
        ];
    }

    /**
     * @return Deal
     */
    public function create()
    {
        $deal = new Deal();
        $deal->setAccount($this->accountManager->getCurrentAccount());

        return $deal;
    }
} 