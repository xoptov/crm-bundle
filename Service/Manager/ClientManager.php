<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\NoResultException;
use Perfico\CRMBundle\Service\Search\PrepareAccountTrait;
use Perfico\CRMBundle\Service\Search\PrepareChannelTrait;
use Perfico\CRMBundle\Service\Search\PrepareCreatedRangeTrait;
use Perfico\CRMBundle\Service\Search\PrepareEmailTrait;
use Perfico\CRMBundle\Service\Search\PreparePaginationTrait;
use Perfico\CRMBundle\Service\Search\PreparePhoneTrait;
use Perfico\CRMBundle\Service\Search\PrepareUserTrait;
use Perfico\CoreBundle\Entity\Client;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\ClientConditionInterface;

class ClientManager extends GenericManager
{
    use PrepareAccountTrait;
    use PrepareUserTrait;
    use PrepareEmailTrait;
    use PreparePhoneTrait;
    use PrepareChannelTrait;
    use PrepareCreatedRangeTrait;
    use PreparePaginationTrait;

    /** @var QueryBuilder */
    protected $qb;

    /**
     * @return Client
     */
    public function create()
    {
        $client = new Client();
        $client->setAccount($this->getCurrentAccount());

        if(!$this->securityContext->getToken() instanceof AnonymousToken ) {
            $client->setUser($this->securityContext->getToken()->getUser());
        }

        return $client;
    }

    /**
     * @param string $number
     * @return Client|null
     */
    public function searchByPhone($number)
    {
        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('c')
            ->from('CoreBundle:Client', 'c')
            ->leftJoin('c.phones', 'p')
            ->where('p.number LIKE :number')
            ->setParameter('number', '%' . preg_replace('/^(?:\+7|8)/', '', $number) . '%')
            ->andWhere('c.account = :account')
            ->setParameter('account', $this->getCurrentAccount())
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param ClientConditionInterface $condition
     * @return Client[]
     */
    public function search(ClientConditionInterface $condition)
    {
        $this->qb = $this->em->createQueryBuilder();
        $this->qb->select('c')->from('CoreBundle:Client', 'c');

        $this->initQueryBuilder($condition);
        $this->preparePagination($this->qb, $condition);

        return $this->qb->getQuery()->getResult();
    }

    /**
     * @param ClientConditionInterface $condition
     * @return array
     */
    public function resultCount(ClientConditionInterface $condition)
    {
        $this->qb = $this->em->createQueryBuilder();
        $this->qb->select('COUNT(c)')->from('CoreBundle:Client', 'c');
        $this->initQueryBuilder($condition);

        try {
            $count = (int)$this->qb->getQuery()->getSingleScalarResult();
        } catch (NoResultException $e) {
            $count = 0;
        }

        return $count;
    }

    /**
     * @param ClientConditionInterface $condition
     */
    protected function initQueryBuilder(ClientConditionInterface $condition)
    {
        // Prepare conditions
        $this->prepareAccountCondition($this->qb, $condition, 'c');
        $this->prepareNameCondition($condition);
        $this->prepareUserCondition($this->qb, $condition, 'c');
        $this->prepareEmailCondition($this->qb, $condition, 'c');
        $this->preparePhoneCondition($this->qb, $condition, 'c');
        $this->prepareChannelCondition($this->qb, $condition, 'c');
        $this->prepareCompanyCondition($condition);
        $this->prepareCreatedRangeCondition($this->qb, $condition, 'c');
        $this->prepareDealRangeCondition($condition);
        $this->prepareActivityRangeCondition($condition);
        $this->prepareDealStatesCondition($condition);
        $this->prepareTagsCondition($condition);
//        $this->prepareDelayedPayment($condition);
    }

    /**
     * @param ClientConditionInterface $condition
     */
    protected function prepareNameCondition(ClientConditionInterface $condition)
    {
        if ($condition->getName()) {

            $or = $this->qb->expr()->orX();
            $or->addMultiple([
                $this->qb->expr()->like('c.firstName', ':name_expr'),
                $this->qb->expr()->like('c.middleName', ':name_expr'),
                $this->qb->expr()->like('c.lastName', ':name_expr')
            ]);

            $this->qb->andWhere($or)->setParameter('name_expr', '%' . $condition->getName() . '%');
        }
    }

    /**
     * @param ClientConditionInterface $condition
     */
    protected function prepareDealRangeCondition(ClientConditionInterface $condition)
    {
        if ($condition->getDealFrom() || $condition->getDealTo()) {
            $this->qb->leftJoin('c.deals', 'd1');
        }

        if ($condition->getDealFrom() && $condition->getDealTo()) {

            $createdTo = $condition->getDealTo();
            $createdTo->setTime(23, 59, 59);

            $this->qb->andWhere($this->qb->expr()->between('d1.createdAt', ':createdFrom', ':createdTo'))
                ->setParameter('createdFrom', $condition->getDealFrom())
                ->setParameter('createdTo', $createdTo);;

        } else if ($condition->getDealFrom()) {
            $this->qb->andWhere($this->qb->expr()->gte('d1.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $condition->getDealFrom());
        } else if ($condition->getDealTo()) {

            $createdTo = $condition->getDealTo();
            $createdTo->setTime(23, 59, 59);

            $this->qb->andWhere($this->qb->expr()->lte('d1.createdAt', ':createdTo'))
                ->setParameter('createdTo', $createdTo);
        }
    }

    /**
     * @param ClientConditionInterface $condition
     */
    protected function prepareActivityRangeCondition(ClientConditionInterface $condition)
    {
        if ($condition->getActivityFrom() || $condition->getActivityTo()) {
            $this->qb->leftJoin('c.activities', 'a');
        }

        if ($condition->getActivityFrom() && $condition->getActivityTo()) {

            $createdTo = $condition->getActivityTo();
            $createdTo->setTime(23, 59, 59);

            $this->qb->andWhere($this->qb->expr()->between('a.createdAt', ':createdFrom', ':createdTo'))
                ->setParameter('createdFrom', $condition->getActivityFrom())
                ->setParameter('createdTo', $createdTo);

        } else if ($condition->getActivityFrom()) {

            $this->qb->andWhere($this->qb->expr()->gte('a.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $condition->getActivityFrom());

        } else if ($condition->getActivityTo()) {

            $createdTo = $condition->getActivityTo();
            $createdTo->setTime(23, 59, 59);

            $this->qb->andWhere($this->qb->expr()->lte('a.createdAt', ':createdTo'))
                ->setParameter('createdTo', $createdTo);

        }
    }

    /**
     * @param ClientConditionInterface $condition
     */
    protected function prepareDealStatesCondition(ClientConditionInterface $condition)
    {
        if ($condition->getDealStates() && count($condition->getDealStates())) {
            $this->qb->leftJoin('c.deals', 'd2');

            $this->qb->andWhere($this->qb->expr()->in('d2.state', ':dealStates'))
                ->setParameter('dealStates', $condition->getDealStates());
        }
    }

    /**
     * @param ClientConditionInterface $condition
     */
    protected function prepareTagsCondition(ClientConditionInterface $condition)
    {
        if ($condition->getTags() && count($condition->getTags())) {
            $this->qb->leftJoin('c.tags', 't');

            $this->qb->andWhere($this->qb->expr()->in('t.id', ':tags'))
                ->setParameter('tags', $condition->getTags());
        }
    }

    /**
     * @param ClientConditionInterface $condition
     */
    protected function prepareDelayedPayment(ClientConditionInterface $condition)
    {
        //TODO need implementation for this method
    }

    /**
     * @param ClientConditionInterface $condition
     */
    protected function prepareCompanyCondition(ClientConditionInterface $condition)
    {
        if ($condition->getCompany()) {
            $this->qb->andWhere($this->qb->expr()->eq('c.company', ':company'))
                ->setParameter('company', $condition->getCompany());
        }
    }
}