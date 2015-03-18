<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CRMBundle\Service\Search\PrepareAccountTrait;
use Perfico\CRMBundle\Service\Search\PrepareChannelTrait;
use Perfico\CRMBundle\Service\Search\PrepareCreatedRangeTrait;
use Perfico\CRMBundle\Service\Search\PrepareEmailTrait;
use Perfico\CRMBundle\Service\Search\PreparePaginationTrait;
use Perfico\CRMBundle\Service\Search\PreparePhoneTrait;
use Perfico\CRMBundle\Service\Search\PrepareUserTrait;
use Perfico\CRMBundle\Transformer\Converter\ChannelConverter;
use Perfico\CRMBundle\Transformer\Converter\UserConverter;
use Perfico\CoreBundle\Entity\Client;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Perfico\CRMBundle\Search\ClientCondition;

class ClientManager extends GenericManager
{
    use PrepareAccountTrait;
    use PrepareUserTrait;
    use PrepareEmailTrait;
    use PreparePhoneTrait;
    use PrepareChannelTrait;
    use PrepareCreatedRangeTrait;
    use PreparePaginationTrait;

    /**
     * @return \Doctrine\ORM\QueryBuilder
     * @deprecated
     */
    public function getAccountClientsQuery()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Client');

        return $repo->createQueryBuilder('c')
            ->where('c.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount());
    }

    /**
     * @param null $onlyForUser
     * @return Client[]
     * @deprecated
     */
    public function getAccountClients($onlyForUser = null)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Client');

        $builder = $repo->createQueryBuilder('c')
            ->where('c.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
            ;

        if ($onlyForUser) {
            $builder->andWhere('c.user = :user')
                ->setParameter('user', $onlyForUser)
                ;
        }

        $builder->orderBy('c.createdAt', 'DESC');

        return $builder
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $onlyForUser
     * @return integer
     * @deprecated
     */
    public function getCountAccountClients($onlyForUser = null)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Client');

        $builder = $repo->createQueryBuilder('c')
            ->select('count(c)')
            ->where('c.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
            ;

        if ($onlyForUser) {
            $builder
                ->andWhere('c.user = :user')
                ->setParameter('user', $onlyForUser)
                ;
        }

        return $builder
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param object $filter
     * @return object
     * @deprecated
     */
    public function filterConverter($filter){
        if ($filter->channel) {
            /** @var ChannelConverter $channelConverter */
            $channelConverter = new ChannelConverter($this->em);
            $channelConverter->setEntityClass('CoreBundle:Channel');
            $filter->channel = $channelConverter->convert($filter->channel);
        }

        if ($filter->user) {
            /** @var UserConverter $userConverter */
            $userConverter = new UserConverter($this->em);
            $userConverter->setEntityClass('UserBundle:User');
            $filter->user = $userConverter->convert($filter->user);
        }

        if (is_array($filter->tags))
        {
            $tags = [];
            foreach($filter->tags as $tag)
            {
                $tags[] = $this->em->getReference('CoreBundle:Tag', $tag->id);
            }
            $filter->tags = $tags;
        }

        return $filter;
    }

    /**
     * @param $filter
     * @param null $onlyForUser
     * @return QueryBuilder
     * @deprecated
     */
    public function getQueryBuilder($filter, $onlyForUser = null)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Client');

        $builder = $repo->createQueryBuilder('c')
            ->where('c.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount());

        if (
            ($onlyForUser) &&
            (!$filter->user)
        )
        {
            $builder->andWhere('c.user = :user')
                ->setParameter('user', $onlyForUser);
        }

        if ($filter->user) {
            $builder->andWhere('c.user = :user')
                ->setParameter('user', $filter->user);
        }

        if ($filter->firstName) {
            $builder->andWhere('c.firstName like :firstName')->setParameter('firstName', '%'.$filter->firstName.'%');
        }

        if ($filter->lastName) {
            $builder->andWhere('c.lastName like :lastName')->setParameter('lastName', '%'.$filter->lastName.'%');
        }

        if ($filter->middleName) {
            $builder->andWhere('c.middleName like :middleName')->setParameter('middleName', '%'.$filter->middleName.'%');
        }

        if (($filter->phone) && (!$filter->withoutPhone)) {
            $builder->innerJoin('c.phones','p');
            $builder->andWhere('p.number like :phone')->setParameter('phone', '%'.$filter->phone.'%');
        }

        if ($filter->withoutPhone) {
            /** @TODO: refactor! */
            $builder->andWhere(
                $builder->expr()->not(
                    $builder->expr()->exists('SELECT p
                        FROM Perfico\CoreBundle\Entity\Phone p
                        WHERE p.client = c'
                    )
                )
            );
        }

        if ($filter->channel)
        {
            $builder->andWhere('c.channel = :channel')
                ->setParameter('channel', $filter->channel);
        }

        if (($filter->email)&&(!$filter->withoutEmail))
        {
            $builder->andWhere('c.email like :email')
                ->setParameter('email', '%'.$filter->email.'%');
        }

        if ($filter->withoutEmail) {
            $builder->andWhere('c.email is null');
        }

        if (is_array($filter->tags)) {
            foreach($filter->tags as $tag) {
                $builder
                    ->andWhere(':tag'.$tag->getId().' MEMBER OF c.tags')
                    ->setParameter('tag'.$tag->getId(), $tag);
            }
        }

        $builder
            ->orderBy('c.createdAt', 'DESC');

        return $builder;
    }
    /**
     * Returns array of account clients and them count
     * Array keys:
     *          - items - contains filtered clients collection
    *           - count - contains count of all filtered clients
     *
     * @param integer $page
     * @param integer $limit
     * @param object $filter
     * @param null $onlyForUser
     * @return Client[]
     * @deprecated
     */
    public function getAccountClientsPage($page, $limit, $filter, $onlyForUser = null)
    {
        $filter = $this->filterConverter($filter);

        $builderItems = $this->getQueryBuilder($filter, $onlyForUser);
        $builderCount = $this->getQueryBuilder($filter, $onlyForUser);

        $items = $builderItems
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        $count = $builderCount
            ->select('count(c)')
            ->getQuery()
            ->getSingleScalarResult();

        return [
            'items' => $items,
            'count' => $count
        ];
    }

    /**
     * @return Client
     */
    public function create()
    {
        $client = new Client();
        $client->setAccount($this->accountManager->getCurrentAccount());

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
        /** @var QueryBuilder $qb */
        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('c')
            ->from('CoreBundle:Client', 'c')
            ->leftJoin('c.phones', 'p')
            ->where('p.number LIKE :number')->setParameter('number', '%' . preg_replace('/^(?:\+7|8)/', '', $number) . '%')
            ->andWhere('c.account = :account')->setParameter('account', $this->accountManager->getCurrentAccount())
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param ClientCondition $condition
     * @return Client[]
     */
    public function search(ClientCondition $condition)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('c')->from('CoreBundle:Client', 'c');

        // Prepare conditions
        $this->prepareAccountCondition($qb, $condition, 'c');
        $this->prepareNameCondition($qb, $condition);
        $this->prepareUserCondition($qb, $condition, 'c');
        $this->prepareEmailCondition($qb, $condition, 'c');
        $this->preparePhoneCondition($qb, $condition, 'c');
        $this->prepareChannelCondition($qb, $condition, 'c');
        $this->prepareCompanyCondition($qb, $condition);
        $this->prepareCreatedRangeCondition($qb, $condition, 'c');
        $this->prepareDealRangeCondition($qb, $condition);
        $this->prepareActivityRangeCondition($qb, $condition);
        $this->prepareDealStatesCondition($qb, $condition);
//        $this->prepareTagsCondition($qb, $condition);
//        $this->prepareDelayedPayment($qb, $condition);
        $this->preparePagination($qb, $condition);

        return $qb->getQuery()->getResult();
    }

    protected function prepareNameCondition(QueryBuilder $qb, ClientCondition $condition)
    {
        if ($condition->getName()) {

            $or = $qb->expr()->orX();
            $or->addMultiple([
                $qb->expr()->like('c.firstName', ':name_expr'),
                $qb->expr()->like('c.middleName', ':name_expr'),
                $qb->expr()->like('c.lastName', ':name_expr')
            ]);

            $qb->andWhere($or)->setParameter('name_expr', '%' . $condition->getName() . '%');
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientCondition $condition
     */
    protected function prepareDealRangeCondition(QueryBuilder $qb, ClientCondition $condition)
    {
        if ($condition->getDealFrom() || $condition->getDealTo()) {
            $qb->innerJoin('c.deals', 'd1');
        }

        if ($condition->getDealFrom() && $condition->getDealTo()) {
            $qb->andWhere($qb->expr()->between('d1.createdAt', ':createdFrom', ':createdTo'))
                ->setParameter('createdFrom', $condition->getDealFrom())
                ->setParameter('createdTo', $condition->getDealTo());;

        } else if ($condition->getDealFrom()) {
            $qb->andWhere($qb->expr()->lte('d1.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $condition->getDealFrom());
        } else if ($condition->getDealTo()) {
            $qb->andWhere($qb->expr()->lte('d1.createdAt', ':createdTo'))
                ->setParameter('createdTo', $condition->getDealTo());
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientCondition $condition
     */
    protected function prepareActivityRangeCondition(QueryBuilder $qb, ClientCondition $condition)
    {
        if ($condition->getActivityFrom() || $condition->getActivityTo()) {
            $qb->innerJoin('c.activities', 'a');
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
                ->setParameter('createdTo', $condition->getActivityTo());

        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientCondition $condition
     */
    protected function prepareDealStatesCondition(QueryBuilder $qb, ClientCondition $condition)
    {
        if ($condition->getDealStates() && count($condition->getDealStates())) {
            $qb->innerJoin('c.deals', 'd2');

            $qb->andWhere($qb->expr()->in('d2.state', ':dealStates'))
                ->setParameter('dealStates', $condition->getDealStates());
        }
    }

    protected function prepareTagsCondition(QueryBuilder $qb, ClientCondition $condition)
    {
        //TODO need implementation for this method
    }

    protected function prepareDelayedPayment(QueryBuilder $qb, ClientCondition $condition)
    {
        //TODO need implementation for this method
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientCondition $condition
     */
    protected function prepareCompanyCondition(QueryBuilder $qb, ClientCondition $condition)
    {
        if ($condition->getCompany()) {
            $qb->andWhere($qb->expr()->eq('c.company', ':company'))
                ->setParameter('company', $condition->getCompany());
        }
    }
}