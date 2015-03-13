<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\QueryBuilder;
use Perfico\CoreBundle\Entity\Company;
use Perfico\CRMBundle\Search\CompanyCondition;
use Perfico\CRMBundle\Service\Search\PrepareAccountTrait;
use Perfico\CRMBundle\Service\Search\PrepareNameTrait;
use Perfico\CRMBundle\Service\Search\PreparePaginationTrait;
use Perfico\CRMBundle\Service\Search\PreparePhoneTrait;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Doctrine\ORM\EntityRepository;

class CompanyManager extends GenericManager
{
    use PrepareAccountTrait;
    use PrepareNameTrait;
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
     * @param CompanyCondition $conditions
     * @return Company[]
     */
    public function search(CompanyCondition $conditions)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('co')->from('CoreBundle:Company', 'co');

        $this->prepareAccountCondition($qb, $conditions, 'co');
        $this->prepareNameCondition($qb, $conditions, 'co');
        $this->prepareDealRangeCondition($qb, $conditions);
        $this->prepareActivityRangeCondition($qb, $conditions);
        $this->prepareTagsCondition($qb, $conditions);
        $this->prepareDealStatesCondition($qb, $conditions);
        $this->prepareDelayedPaymentCondition($qb, $conditions);
        $this->preparePagination($qb, $conditions);

        return $qb->getQuery()->getResult();

    }

    protected function prepareDealRangeCondition(QueryBuilder $qb, CompanyCondition $conditions)
    {

    }

    protected function prepareActivityRangeCondition(QueryBuilder $qb, CompanyCondition $conditions)
    {

    }

    protected function prepareTagsCondition(QueryBuilder $qb, CompanyCondition $conditions)
    {
        //TODO need implementation
    }

    protected function prepareDealStatesCondition(QueryBuilder $qb, CompanyCondition $conditions)
    {

    }

    protected function prepareDelayedPaymentCondition(QueryBuilder $qb, CompanyCondition $conditions)
    {
        //TODO need implementation
    }
}