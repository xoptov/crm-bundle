<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Channel;
use Doctrine\ORM\EntityRepository;

class ChannelManager extends GenericManager
{
    /**
     * @return Channel[]
     * @todo need refactoring this method
     */
    public function getAccountChannels()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Channel');

        return $repo->createQueryBuilder('c')
            ->where('c.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Channel
     */
    public function create()
    {
        $client = new Channel();
        $client->setAccount($this->accountManager->getCurrentAccount());

        return $client;
    }
} 