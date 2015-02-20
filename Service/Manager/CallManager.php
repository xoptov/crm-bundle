<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Call;
use Perfico\CRMBundle\Entity\ClientInterface;

class CallManager extends GenericManager
{
    public function create()
    {

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
            ->innerJoin('c.activity', 'a')
            ->where('a.client = :client')->setParameter('client', $client)
            ->andWhere('a.account = :account')->setParameter('account', $this->accountManager->getCurrentAccount())
            ->getQuery();

        return $query->getResult();
    }
}