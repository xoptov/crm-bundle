<?php

namespace Perfico\CRMBundle\Service\Manager\PBX;

use Doctrine\ORM\EntityManager;
use Perfico\CoreBundle\Entity\Activity;
use Perfico\CoreBundle\Entity\Call;
use Perfico\CRMBundle\Entity\AccountInterface;
use Perfico\CRMBundle\Entity\ActivityInterface;

class CallManager
{
    /** @var EntityManager */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $callId
     * @param AccountInterface $account
     * @return Call
     */
    public function retrieveCall($callId, AccountInterface $account)
    {
        $call = $this->em->getRepository('CoreBundle:Call')
            ->findOneBy(array('pbxCallId' => $callId, 'account' => $account));

        if ($call == null) {
            $call = new Call();
            $this->em->persist($call);

            $activity = new Activity();
            $this->em->persist($activity);

            $call->setPbxCallId($callId)
                ->setActivity($activity)
                ->setAccount($account);

            $activity->setType(ActivityInterface::TYPE_CALL)
                ->setAccount($account);
        }

        return $call;
    }
} 