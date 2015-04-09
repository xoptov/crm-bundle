<?php

namespace Perfico\CRMBundle\Service\Telephony;

use Doctrine\ORM\EntityManagerInterface;
use Perfico\CRMBundle\Entity\ClientInterface;
use Perfico\SipuniBundle\Entity\CallEventInterface;
use Perfico\CRMBundle\Entity\Call;

class SkypeManager implements TelephonyManager
{
    /** @var EntityManagerInterface */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function checkFormat($value)
    {
        return preg_match('/^[a-z][_a-z0-9,\.\-]{5,31}$/i', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function searchSourceUser(CallEventInterface $ce)
    {
        /** @var Call $call */
        $call = $ce->getCall();
        $qb = $this->em->createQueryBuilder();

        $query = $qb->select('u')
            ->from('UserBundle:User', 'u')
            ->leftJoin('u.groups', 'g')
            ->leftJoin('u.contacts', 'c')
            ->where('g.account = :account')->setParameter('account', $call->getAccount())
            ->andWhere('c.skype LIKE :skype')->setParameter('skype', '%' . $ce->getSrcNumber() . '%')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function searchDestinationUser(CallEventInterface $ce)
    {
        /** @var Call $call */
        $call = $ce->getCall();
        $qb = $this->em->createQueryBuilder();

        $query = $qb->select('u')
            ->from('UserBundle:User', 'u')
            ->leftJoin('u.groups', 'g')
            ->leftJoin('u.contacts', 'c')
            ->where('g.account = :account')->setParameter('account', $call->getAccount())
            ->andWhere('c.skype LIKE :skype')->setParameter('skype', '%' . $ce->getDstNumber() . '%')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param CallEventInterface $ce
     * @return null
     */
    public function searchSourceClient(CallEventInterface $ce)
    {
        return null;
    }

    /**
     * @param CallEventInterface $ce
     * @return null
     */
    public function searchDestinationClient(CallEventInterface $ce)
    {
        return null;
    }

    /**
     * @param ClientInterface $client
     * @param string $value
     * @return void
     */
    public function prepareNewClient(ClientInterface $client, $value)
    {
        //TODO must be implemented if need set skype id to Client
    }
} 