<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;

class TagManager extends GenericManager
{
    /**
     * @return Tag[]
     * @todo need refactoring this method
     */
    public function getAccountClients()
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Tag');

        $builder = $repo->createQueryBuilder('ct')
            ->where('ct.account = :account')
            ->setParameter('account', $this->accountManager->getCurrentAccount())
            ;

        return $builder
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Tag
     */
    public function create()
    {
        $tag = new Tag();
        $tag->setAccount($this->accountManager->getCurrentAccount());

        return $tag;
    }
}