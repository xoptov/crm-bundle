<?php

namespace Perfico\CRMBundle\Service\Telephony;

use Perfico\CRMBundle\Entity\ClientInterface;
use Perfico\CRMBundle\Service\Manager\PhoneManager as BasePhoneManager;
use Perfico\SipuniBundle\Entity\CallEventInterface;
use Perfico\CRMBundle\Entity\Call;

class PhoneManager extends BasePhoneManager implements TelephonyManager
{
    /**
     * {@inheritdoc}
     */
    public function checkFormat($value)
    {
        return preg_match('/^(?:\+?7|8)[0-9]{10,14}$/', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function searchSourceUser(CallEventInterface $ce)
    {
        /** @var Call $call */
        $call = $ce->getCall();
        $number = $this->clearNumber($ce->getSrcNumber());

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('u')
            ->from('UserBundle:User', 'u')
            ->leftJoin('u.groups', 'g')
            ->leftJoin('u.contacts', 'c')
            ->where('g.account = :account')->setParameter('account', $call->getAccount())
            ->andWhere('c.phone LIKE :phone')->setParameter('phone', '%' . $number . '%')
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
        $number = $this->clearNumber($ce->getDstNumber());

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('u')
            ->from('UserBundle:User', 'u')
            ->leftJoin('u.groups', 'g')
            ->leftJoin('u.contacts', 'c')
            ->where('g.account = :account')->setParameter('account', $call->getAccount())
            ->andWhere('c.phone LIKE :phone')->setParameter('phone', '%' . $number . '%')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function searchSourceClient(CallEventInterface $ce)
    {
        /** @var Call $call */
        $call = $ce->getCall();
        $number = $this->clearNumber($ce->getSrcNumber());

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('c')
            ->from('CoreBundle:Client', 'c')
            ->leftJoin('c.phones', 'p')
            ->where('p.account = :account')->setParameter('account', $call->getAccount())
            ->andWhere('p.number LIKE :number')->setParameter('number', '%' . $number . '%')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();

    }

    /**
     * {@inheritdoc}
     */
    public function searchDestinationClient(CallEventInterface $ce)
    {
        /** @var Call $call */
        $call = $ce->getCall();
        $number = $this->clearNumber($ce->getDstNumber());

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('c')
            ->from('CoreBundle:Client', 'c')
            ->leftJoin('c.phones', 'p')
            ->where('p.account = :account')->setParameter('account', $call->getAccount())
            ->andWhere('p.number LIKE :number')->setParameter('number', '%' . $number . '%')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param string $number
     * @return string
     */
    protected function clearNumber($number)
    {
        return preg_replace('/^(?:\+?7|8)/', '', $number);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareNewClient(ClientInterface $client, $value)
    {
        $phone = $this->create();
        $phone->setClient($client);
        $phone->setNumber($value);

        $this->em->persist($phone);
    }
} 