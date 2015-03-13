<?php

namespace Perfico\CRMBundle\Service\Manager;

use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\Query\Expr\Composite;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\Expr\Orx;
use Doctrine\ORM\Query\QueryException;
use Perfico\CRMBundle\Model\ClientSearch;
use Perfico\CRMBundle\Transformer\Converter\ChannelConverter;
use Perfico\CRMBundle\Transformer\Converter\UserConverter;
use Perfico\CoreBundle\Entity\Client;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class ClientManager extends GenericManager
{
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
     * @param ClientSearch $conditions
     * @return Client[]
     */
    public function search(ClientSearch $conditions)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('c')->from('CoreBundle:Client', 'c');

        // Prepare conditions
        $this->prepareAccountCondition($qb, $conditions);
        $this->prepareNameCondition($qb, $conditions);
        $this->prepareUserCondition($qb, $conditions);
        $this->prepareEmailCondition($qb, $conditions);
        $this->preparePhoneCondition($qb, $conditions);
        $this->prepareChannelCondition($qb, $conditions);
        $this->prepareCreatedRangeCondition($qb, $conditions);
        $this->prepareDealRangeCondition($qb, $conditions);
        $this->prepareActivityRangeCondition($qb, $conditions);
        $this->prepareDealStatesCondition($qb, $conditions);
        // TODO need implementation prepare tags condition method
        $this->preparePagination($qb, $conditions);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param QueryBuilder $qb
     * @param $condition
     * @throws QueryException
     * @deprecated
     */
    protected function prepareWhere(QueryBuilder $qb, $condition)
    {
        if (!$condition instanceof Comparison && !$condition instanceof Composite) {
            throw new QueryException();
        }

        if ($qb->getDQLPart('where')) {
            $qb->andWhere($condition);
        } else {
            $qb->where($condition);
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientSearch $conditions
     */
    protected function prepareAccountCondition(QueryBuilder $qb, ClientSearch $conditions)
    {
        if ($conditions->getAccount()) {
            $qb->andWhere($qb->expr()->eq('c.account', ':account'))
                ->setParameter('account', $conditions->getAccount());
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientSearch $conditions
     */
    protected function prepareNameCondition(QueryBuilder $qb, ClientSearch $conditions)
    {
        if ($conditions->getName()) {

            $or = $qb->expr()->orX();
            $or->addMultiple([
                $qb->expr()->like('c.firstName', ':name_expr'),
                $qb->expr()->like('c.middleName', ':name_expr'),
                $qb->expr()->like('c.lastName', ':name_expr')
            ]);

//            $this->prepareWhere($qb, $condition);
            $qb->andWhere($or)->setParameter('name_expr', '%' . $conditions->getName() . '%');
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientSearch $conditions
     */
    protected function prepareUserCondition(QueryBuilder $qb, ClientSearch $conditions)
    {
        if ($conditions->getUser()) {
            $qb->andWhere($qb->expr()->eq('c.user', ':user_id'))
                ->setParameter('user_id', $conditions->getUser());
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientSearch $conditions
     */
    protected function prepareEmailCondition(QueryBuilder $qb, ClientSearch $conditions)
    {
        if ($conditions->getEmail()) {
            $qb->andWhere($qb->expr()->eq('c.email', ':email'))
                ->setParameter('email', $conditions->getEmail());
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientSearch $conditions
     */
    protected function preparePhoneCondition(QueryBuilder $qb, ClientSearch $conditions)
    {
        if ($conditions->getPhone()) {
            $qb->innerJoin('c.phones', 'p');
            $number = preg_replace('/^(?:\+7|\+?8)|[\(\)\-\s\W]+/', '', $conditions->getPhone());
            $qb->andWhere($qb->expr()->like('p.number', ':number'))
                ->setParameter('number', '%' . $number . '%');
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientSearch $conditions
     */
    protected function prepareChannelCondition(QueryBuilder $qb, ClientSearch $conditions)
    {
        if ($conditions->getChannel()) {
            $qb->andWhere($qb->expr()->eq('c.channel', ':channel'))
                ->setParameter('channel', $conditions->getChannel());
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientSearch $conditions
     */
    protected function prepareCreatedRangeCondition(QueryBuilder $qb, ClientSearch $conditions)
    {
        if ($conditions->getCreatedFrom() && $conditions->getCreatedTo()) {

            $condition = $qb->expr()->between('c.createdAt', ':createdFrom', ':createdTo');
            $qb->andWhere($condition)
                ->setParameter('createdFrom', $conditions->getCreatedFrom())
                ->setParameter('createdTo', $conditions->getCreatedTo());

        } else if ($conditions->getCreatedFrom()) {

            $qb->andWhere($qb->expr()->lte('c.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $conditions->getCreatedFrom());

        } else if ($conditions->getCreatedTo()) {

            $qb->andWhere($qb->expr()->gte('c.createdAt', ':createdTo'))
                ->setParameter('createdTo', $conditions->getCreatedTo());

        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientSearch $conditions
     */
    protected function prepareDealRangeCondition(QueryBuilder $qb, ClientSearch $conditions)
    {
        if ($conditions->getDealFrom() || $conditions->getDealTo()) {
            $qb->innerJoin('c.deals', 'd');
        }

        if ($conditions->getDealFrom() && $conditions->getDealTo()) {
            $condition = $qb->expr()->between('d.createdAt', ':createdFrom', ':createdTo');

            $qb->andWhere($condition)
                ->setParameter('createdFrom', $conditions->getDealFrom())
                ->setParameter('createdTo', $conditions->getDealTo());
        } else if ($conditions->getDealFrom()) {
            $qb->andWhere($qb->expr()->lte('d.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $conditions->getDealFrom());
        } else if ($conditions->getDealTo()) {
            $qb->andWhere($qb->expr()->lte('d.createdAt', ':createdTo'))
                ->setParameter('createdTo', $conditions->getDealTo());
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientSearch $conditions
     */
    protected function prepareActivityRangeCondition(QueryBuilder $qb, ClientSearch $conditions)
    {
        if ($conditions->getActivityFrom() || $conditions->getActivityTo()) {
            $qb->innerJoin('c.activities', 'a');
        }

        if ($conditions->getActivityFrom() && $conditions->getActivityTo()) {

            $condition = $qb->expr()->between('a.createdAt', ':createdFrom', ':createdTo');
            $qb->andWhere($condition)
                ->setParameter('createdFrom', $conditions->getActivityFrom())
                ->setParameter('createdTo', $conditions->getActivityTo());

        } else if ($conditions->getActivityFrom()) {

            $qb->andWhere($qb->expr()->lte('a.createdAt', ':createdFrom'))
                ->setParameter('createdFrom', $conditions->getActivityFrom());

        } else if ($conditions->getActivityTo()) {

            $qb->andWhere($qb->expr()->gte('a.createdAt', 'createdTo'))
                ->setParameter('createdTo', $conditions->getActivityTo());

        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientSearch $conditions
     */
    protected function prepareDealStatesCondition(QueryBuilder $qb, ClientSearch $conditions)
    {
        if ($conditions->getDealStates() && count($conditions->getDealStates())) {
            $qb->innerJoin('c.deals', 'd')
                ->innerJoin('d.state', 's')
                ->andWhere($qb->expr()->in('s.id', $conditions->getDealStates()));
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ClientSearch $conditions
     */
    protected function preparePagination(QueryBuilder $qb, ClientSearch $conditions)
    {
        if ($conditions->getOffset()) {
            $qb->setFirstResult($conditions->getOffset());
        }

        if ($conditions->getLimit()) {
            $qb->setMaxResults($conditions->getLimit());
        }
    }
}