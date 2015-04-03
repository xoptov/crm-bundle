<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Payment;
use Doctrine\ORM\EntityRepository;

class PaymentManager extends GenericManager
{
    /**
     * @return Payment[]
     * @todo need refactoring this method
     */
    public function getAccountPayments()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Payment');

        return $repo->createQueryBuilder('p')
            ->where('p.account = :account')
            ->setParameter('account', $this->getCurrentAccount())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Payment
     */
    public function create()
    {
        $payment = new Payment();
        $payment->setAccount($this->getCurrentAccount());

        return $payment;
    }
} 