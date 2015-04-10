<?php

namespace Perfico\CRMBundle\Service\Manager;

use Perfico\CoreBundle\Entity\Activity;
use Perfico\CoreBundle\Entity\Client;
use Perfico\CoreBundle\Entity\Company;
use Perfico\CRMBundle\Entity\Call;
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
     * @param Company $company
     * @return Activity[]
     * @todo need refactoring this method
     */
    public function getByCompany(Company $company)
    {
        return $this->em
            ->createQueryBuilder()->select('a')
            ->from('CoreBundle:Activity', 'a')
            ->innerJoin('a.client', 'c')
            ->where('c.company = :company')
            ->setParameter('company', $company)
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
        $activity->setAccount($this->getCurrentAccount());

        if(!$this->securityContext->getToken() instanceof AnonymousToken ) {
            $activity->setUser($this->securityContext->getToken()->getUser());
        }

        return $activity;
    }

    public function prepareIncomingCallNote(Call $call)
    {
        $status = $this->translator->trans('activity.status.' . $call->getHangupEvent()->getStatus());

        $note = $this->translator->trans('activity.note.datetime', array('%dateTime%' => $call->getEndTalk()->format('d.m.Y H:i')));
        $note .= $this->translator->trans('activity.note.status', array('%status%' => $status));

        if ($call->getStartTalk() && $call->getEndTalk()) {
            $note .= $this->translator->trans('activity.note.duration', array(
                '%duration%' => $call->getStartTalk()->diff($call->getEndTalk())->format('%H:%I:%S')
            ));
        }

        $note .= $this->translator->trans('activity.note.manager', array(
            '%manager%' => $call->getUser()->getFullName(),
            '%phone%' => $call->getAnswerEvent()->getSrcNumber()
        ));

        $call->getActivity()->setNote($note);
    }
} 