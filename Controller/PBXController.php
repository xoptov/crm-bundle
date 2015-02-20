<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Event\PBXEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Perfico\CRMBundle\Service\Manager\PBX\CallManager;

class PBXController extends Controller
{
    /**
     * @Route("/pbx/callback")
     */
    public function indexAction(Request $request)
    {
        if ($request->get('call_id') == null) {
            throw new BadRequestHttpException('call_id must be specified');
        }

        /** @var CallManager $callManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $callManager = $this->get('perfico_crm.pbx.call_manager');
        $pvm = $this->get('perfico_crm.pbx.event_manager');
        $dispatcher = $this->get('event_dispatcher');

        $account = $this->get('perfico_crm.account_manager')->getCurrentAccount();
        $call = $callManager->retrieveCall($request->get('call_id'), $account);

        $factory = $pvm->getFactory($request);
        $callEvent = $factory->create();
        $factory->hydration($callEvent, $request, $call);

        $pvm->processing($callEvent);
        $pvm->determineUser($callEvent);

        switch (get_class($callEvent)) {

            case 'Perfico\CRMBundle\Entity\PBX\Sipuni\AnswerEvent':
                $pvm->relateAnswerEvent($callEvent);
                break;

            case 'Perfico\CRMBundle\Entity\PBX\Sipuni\HangupEvent':
                $pvm->relateHangupEvent($callEvent);
                $pvm->prepareActivityNote($callEvent);
                break;

        }

        $entityManager->persist($callEvent);

        $event = new PBXEvent();
        $event->setCallEvent($callEvent);

        $dispatcher->dispatch(PBXEvent::CALL_EVENT, $event);

        $entityManager->flush();

        return new JsonResponse(array('success' => true));
    }
} 