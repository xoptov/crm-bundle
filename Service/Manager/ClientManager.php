<?php

namespace Perfico\CRMBundle\Service\Manager;

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
            $clientTags = [];
            foreach($filter->tags as $tag)
            {
                $clientTags[] = $this->em->getReference('CoreBundle:ClientTag', $tag->id);
            }
            $filter->tags = $clientTags;
        }

        return $filter;
    }

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
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}