<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Company;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Doctrine\ORM\EntityRepository;

class CompanyManager extends GenericManager
{
    /**
     * @param null $onlyForUser
     * @return Company[]
     * @todo need refactoring this method
     */
    public function getAccountCompanies($onlyForUser = null)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Company');

        $builder = $repo->createQueryBuilder('c')
            ->where('c.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
        ;

        return $builder
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Company
     */
    public function create()
    {
        $company = new Company();
        $company->setAccount($this->accountManager->getCurrentAccount());

        if(!$this->securityContext->getToken() instanceof AnonymousToken ) {
            $company->setUser($this->securityContext->getToken()->getUser());
        }

        return $company;
    }

}