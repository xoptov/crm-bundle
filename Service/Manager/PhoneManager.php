<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Phone;
use Doctrine\ORM\EntityRepository;
use Perfico\CoreBundle\Entity\Client;

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
            ->setParameter('account', $this->getCurrentAccount())
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
        $phone->setAccount($this->getCurrentAccount());

        return $phone;
    }
} 