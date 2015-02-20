<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Activity;
use Perfico\CoreBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Doctrine\ORM\EntityRepository;

class ActivityManager extends GenericManager
{
    /** @var Translator */
    protected $translator;

    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Get activity types array - format icon => title
     * @return array
     */
    public function getActivityTypes()
    {
        $result = array();

        foreach (Activity::getTypes() as $key=>$value) {
            $result[$key] = $this->translator->trans($value);
        }

        return $result;
    }

    /**
     * @param Client $client
     * @return Activity[]
     * @todo need refactoring this method
     */
    public function getClientActivity(Client $client)
    {
        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Activity');

        return $repo->createQueryBuilder('ca')
            ->where('ca.client = :client')
            ->setParameter('client', $client)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Activity[]
     * @todo need refactoring this method
     */
    public function getAccountActivities()
    {
        $account = $this->accountManager->getCurrentAccount();

        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository('CoreBundle:Activity');

        return $repo->createQueryBuilder('ca')
            ->where('ca.account = :account')
            ->setParameter('account', $account)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Activity
     */
    public function create()
    {
        $activity = new Activity();

        if(!$this->securityContext->getToken() instanceof AnonymousToken ) {
            $activity->setAccount($this->accountManager->getCurrentAccount());
        }

        return $activity;
    }
} 