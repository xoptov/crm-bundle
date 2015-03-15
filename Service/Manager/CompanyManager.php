<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\QueryBuilder;
use Perfico\CoreBundle\Entity\Company;
use Perfico\CRMBundle\Search\CompanyCondition;
use Perfico\CRMBundle\Service\Search\PrepareAccountTrait;
use Perfico\CRMBundle\Service\Search\PreparePaginationTrait;
use Perfico\CRMBundle\Service\Search\PreparePhoneTrait;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Doctrine\ORM\EntityRepository;

class CompanyManager extends GenericManager
{
    use PrepareAccountTrait;
    use PreparePhoneTrait;
    use PreparePaginationTrait;

    /**
     * @return Company[]
     */
    public function getAllCompanies()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Company');

        return $repo->createQueryBuilder('c')
            ->where('c.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Company
     */
    public function create()
    {
        $company = new Company();
        $company->setAccount($this->accountManager->getCurrentAccount());

        if(!$this->securityContext->getToken() instanceof AnonymousToken ) {
            $company->setUser($this->securityContext->getToken()->getUser());
        }

        return $company;
    }

    /**
     * @param CompanyCondition $condition
     * @return Company[]
     */
    public function search(CompanyCondition $condition)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('co')->from('CoreBundle:Company', 'co');

        $this->prepareAccountCondition($qb, $condition, 'co');
        $this->prepareNameCondition($qb, $condition, 'co');
        $this->prepareDealRangeCondition($qb, $condition);
        $this->prepareActivityRangeCondition($qb, $condition);
        $this->prepareDealStatesCondition($qb, $condition);
//        $this->prepareTagsCondition($qb, $condition);
//        $this->prepareDelayedPaymentCondition($qb, $condition);
        $this->preparePagination($qb, $condition);

        return $qb->getQuery()->getResult();

    }

    protected function prepareNameCondition(QueryBuilder $qb, CompanyCondition $condition)
    {
        if ($condition->getName()) {
            $qb->andWhere($qb->expr()->like('co.name', ':name_expr'))
                ->setParameter('name_expr', '%' . $condition->getName() . '%');
        }
    }

    protected function prepareDealRangeCondition(QueryBuilder $qb, CompanyCondition $condition)
    {
        if ($condition->getDealFrom() || $condition->getDealTo()) {
            $qb->innerJoin('co.clients', 'c1');
            $qb->innerJoin('c1.deals', 'd1');
        }

        if ($condition->getDealFrom() && $condition->getDealTo()) {
            $qb->andWhere($qb->expr()->between('d1.createdAt', ':createdFrom', ':createdTo'))
                ->setParameter('createdFrom', $condition->getDealFrom())
                ->setParameter('createdTo', $condition->getDealTo());
        } else if ($condition->getDealFrom()) {
            $qb->andWhere($qb->expr()->lte('d1.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $condition->getDealFrom());
        } else if ($condition->getDealTo()) {
            $qb->andWhere($qb->expr()->gte('d1.createdAt', ':createdTo'));
        }
    }

    protected function prepareActivityRangeCondition(QueryBuilder $qb, CompanyCondition $condition)
    {
        if ($condition->getActivityFrom() || $condition->getActivityTo()) {
            $qb->innerJoin('co.clients', 'c2');
            $qb->innerJoin('c2.activities', 'a');
        }

        if ($condition->getActivityFrom() && $condition->getActivityTo()) {
            $qb->andWhere($qb->expr()->between('a.createdAt', ':createdFrom', ':createdTo'))
                ->setParameter('createdFrom', $condition->getActivityFrom())
                ->setParameter('createdTo', $condition->getActivityTo());
        } else if ($condition->getActivityFrom()) {
            $qb->andWhere($qb->expr()->lte('a.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $condition->getActivityFrom());
        } else if ($condition->getActivityTo()) {
            $qb->andWhere($qb->expr()->gte('a.createdAt', ':createdTo'))
                ->setParameter('createdTO', $condition->getActivityTo());
        }
    }

    protected function prepareDealStatesCondition(QueryBuilder $qb, CompanyCondition $condition)
    {
        if ($condition->getDealStates()) {
            $qb->innerJoin('co.clients', 'c3');
            $qb->innerJoin('c3.deals', 'd2');

            $qb->andWhere($qb->expr()->in('d2.state', ':dealStates'))
                ->setParameter('dealStates', $condition->getDealStates());
        }
    }

    protected function prepareTagsCondition(QueryBuilder $qb, CompanyCondition $condition)
    {
        //TODO need implementation
    }


    protected function prepareDelayedPaymentCondition(QueryBuilder $qb, CompanyCondition $condition)
    {
        //TODO need implementation
    }
}