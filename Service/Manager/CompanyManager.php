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

    /** @var QueryBuilder */
    protected $qb;

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
        $this->qb = $this->em->createQueryBuilder();
        $this->qb->select('co')->from('CoreBundle:Company', 'co');
        $this->initQueryBuilder($condition);
        $this->preparePagination($this->qb, $condition);

        return $this->qb->getQuery()->getResult();

    }

    /**
     * @param CompanyCondition $condition
     */
    protected function initQueryBuilder(CompanyCondition $condition)
    {
        $this->prepareAccountCondition($this->qb, $condition, 'co');
        $this->prepareNameCondition($condition);
        $this->prepareDealRangeCondition($condition);
        $this->prepareActivityRangeCondition($condition);
        $this->prepareDealStatesCondition($condition);
//        $this->prepareTagsCondition($condition);
//        $this->prepareDelayedPaymentCondition($condition);

    }

    protected function prepareNameCondition(CompanyCondition $condition)
    {
        if ($condition->getName()) {
            $this->qb->andWhere($this->qb->expr()->like('co.name', ':name_expr'))
                ->setParameter('name_expr', '%' . $condition->getName() . '%');
        }
    }

    protected function prepareDealRangeCondition(CompanyCondition $condition)
    {
        if ($condition->getDealFrom() || $condition->getDealTo()) {
            $this->qb->innerJoin('co.clients', 'c1');
            $this->qb->innerJoin('c1.deals', 'd1');
        }

        if ($condition->getDealFrom() && $condition->getDealTo()) {
            $this->qb->andWhere($this->qb->expr()->between('d1.createdAt', ':createdFrom', ':createdTo'))
                ->setParameter('createdFrom', $condition->getDealFrom())
                ->setParameter('createdTo', $condition->getDealTo());
        } else if ($condition->getDealFrom()) {
            $this->qb->andWhere($this->qb->expr()->lte('d1.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $condition->getDealFrom());
        } else if ($condition->getDealTo()) {
            $this->qb->andWhere($this->qb->expr()->gte('d1.createdAt', ':createdTo'));
        }
    }

    protected function prepareActivityRangeCondition(CompanyCondition $condition)
    {
        if ($condition->getActivityFrom() || $condition->getActivityTo()) {
            $this->qb->innerJoin('co.clients', 'c2');
            $this->qb->innerJoin('c2.activities', 'a');
        }

        if ($condition->getActivityFrom() && $condition->getActivityTo()) {
            $this->qb->andWhere($this->qb->expr()->between('a.createdAt', ':createdFrom', ':createdTo'))
                ->setParameter('createdFrom', $condition->getActivityFrom())
                ->setParameter('createdTo', $condition->getActivityTo());
        } else if ($condition->getActivityFrom()) {
            $this->qb->andWhere($this->qb->expr()->lte('a.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $condition->getActivityFrom());
        } else if ($condition->getActivityTo()) {
            $this->qb->andWhere($this->qb->expr()->gte('a.createdAt', ':createdTo'))
                ->setParameter('createdTO', $condition->getActivityTo());
        }
    }

    protected function prepareDealStatesCondition(CompanyCondition $condition)
    {
        if ($condition->getDealStates()) {
            $this->qb->innerJoin('co.clients', 'c3');
            $this->qb->innerJoin('c3.deals', 'd2');

            $this->qb->andWhere($this->qb->expr()->in('d2.state', ':dealStates'))
                ->setParameter('dealStates', $condition->getDealStates());
        }
    }

    protected function prepareTagsCondition(CompanyCondition $condition)
    {
        //TODO need implementation
    }


    protected function prepareDelayedPaymentCondition(CompanyCondition $condition)
    {
        //TODO need implementation
    }
}