<?php

namespace Perfico\CRMBundle\Service\Telephony;

use Perfico\CRMBundle\Entity\Call;
use Perfico\CRMBundle\Entity\ClientInterface;
use Perfico\CRMBundle\Exception\CallSystemDetermineException;
use Perfico\CRMBundle\Exception\ImplementationException;
use Perfico\CRMBundle\Service\Manager\GenericManager;
use Perfico\SipuniBundle\Entity\CallEventInterface;

class CallManager extends GenericManager
{
    /** @var array */
    protected $managers = array();

    /**
     * @param array $managers
     */
    public function setManagers(array $managers)
    {
        $this->managers = $managers;
    }

    public function create()
    {
        throw new ImplementationException;
    }

    /**
     * @return Call[]|array
     */
    public function getCalls()
    {
        return $this->em->getRepository('CoreBundle:Call')
            ->findBy(array('account' => $this->accountManager->getCurrentAccount()));
    }

    /**
     * @param ClientInterface $client
     * @return array|Call[]
     */
    public function getClientCalls(ClientInterface $client)
    {
        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('c')
            ->from('CoreBundle:Call', 'c')
            ->leftJoin('c.activity', 'a')
            ->where('a.client = :client')->setParameter('client', $client)
            ->andWhere('a.account = :account')->setParameter('account', $this->accountManager->getCurrentAccount())
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param CallEventInterface $ce
     * @return TelephonyManager
     * @throws CallSystemDetermineException
     */
    public function getCallerSystem(CallEventInterface $ce)
    {
        /** @var TelephonyManager $manager */
        foreach ($this->managers as $manager) {
            if ($manager->checkFormat($ce->getSrcNumber())){
                return $manager;
            }
        }

        throw new CallSystemDetermineException;
    }

    /**
     * @param CallEventInterface $ce
     * @return TelephonyManager
     * @throws CallSystemDetermineException
     */
    public function getCalledSystem(CallEventInterface $ce)
    {
        /** @var TelephonyManager $manager */
        foreach ($this->managers as $manager) {
            if ($manager->checkFormat($ce->getDstNumber())) {
                return $manager;
            }
        }

        throw new CallSystemDetermineException;
    }
}