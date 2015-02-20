<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Phone;
use Perfico\CoreBundle\Entity\Client;
use Doctrine\ORM\EntityRepository;

class PhoneManager extends GenericManager
{
    /**
     * @return Phone[]
     * @todo need refactoring this method
     */
    public function getAccountPhones()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Phone');

        return $repo->createQueryBuilder('p')
            ->where('p.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Client $client
     * @return Phone[]
     * @todo need refactoring this method
     */
    public function getClientPhones(Client $client)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Phone');

        return $repo->createQueryBuilder('p')
            ->where('p.client = :client')
            ->setParameter('client', $client)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Client $client
     * @param string $number
     * @return Phone[]
     * @todo need refactoring this method
     */
    public function clientPhone(Client $client, $number)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Phone');

        return $repo->createQueryBuilder('p')
            ->andWhere('p.client = :client')
            ->setParameter('client', $client)
            ->andWhere('p.number = :number')
            ->setParameter('number', $number)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Phone
     * @todo need refactoring this method
     */
    public function create()
    {
        $phone = new Phone();
        $phone->setAccount($this->accountManager->getCurrentAccount());

        return $phone;
    }
} 