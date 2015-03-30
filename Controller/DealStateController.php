<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Event\DealStateEvent;
use Perfico\CRMBundle\Entity\DealStateInterface;
use Perfico\CRMBundle\Transformer\Mapping\DealStateMap;
use Perfico\CoreBundle\Entity\DealState;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DealStateController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Deal States",
     *  description="List of all deal states for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/deal-states")
     */
    public function indexAction()
    {
        $dealStates = $this->get('perfico_crm.deal_state_manager')->getAccountDealStates();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($dealStates, new DealStateMap(), 'dealStates')
        );
    }

    /**
     * @ApiDoc(
     *  section="Deal States",
     *  description="Get specified deal state",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/deal-states/{id}")
     * @ParamConverter("dealState", converter="account.doctrine.orm")
     * @param DealState $dealState
     * @return JsonResponse|Response
     */
    public function getAction(DealState $dealState)
    {
        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($dealState, new DealStateMap(), 'dealStates')
        );
    }

    /**
     * @ApiDoc(
     *  section="Deal States",
     *  description="Create new deal state",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"=1},
     *    {"name"="icon", "dataType"="string", "required"=1},
     *   }
     * )
     * @Method("POST")
     * @Route("/deal-states")
     * @return Response|JsonResponse
     */
    public function createAction()
    {
        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Deal States",
     *  description="Remove deal state",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *      {"name"="acceptor", "dataType"="integer", "required"=1, "description"="setting id for switch deal to next state"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/deal-states/{id}")
     * @ParamConverter("dealState", converter="account.doctrine.orm")
     * @param DealState $dealState
     * @return Response
     */
    public function removeAction(DealState $dealState)
    {
        $id = $this->getRequest()->get('acceptor');
        $acceptor = $this->getDoctrine()->getRepository('CoreBundle:DealState')->find($id);

        if (!$acceptor instanceof DealStateInterface) {
            return new JsonResponse(array('acceptor' => $this->get('translator')->trans('errors.deal_state.not_found', array('%id%' => $id))), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $dealState->setAcceptor($acceptor);

        $this->get('perfico_crm.deal_state_manager')->remove($dealState);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Deal States",
     *  description="Update deal state details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"=1},
     *    {"name"="icon", "dataType"="string", "required"=1}
     *   }
     * )
     * @Method("PUT")
     * @Route("/deal-states/{id}")
     * @ParamConverter("dealState", converter="account.doctrine.orm")
     * @param DealState $dealState
     * @return Response
     */
    public function updateAction(DealState $dealState)
    {
        return $this->handleRequest($dealState);
    }

    /**
     * Handle request for deal state process
     * @param DealState $dealState
     * @return JsonResponse|Response
     */
    protected function handleRequest(DealState $dealState = null)
    {
        $dealStateManager = $this->get('perfico_crm.deal_state_manager');
        $dispatcher = $this->get('event_dispatcher');
        if(!$dealState) {
            $eventName = DealStateEvent::DEAL_STATE_ADD_EVENT;
            $dealState = $dealStateManager->create();
        } else {
            $eventName = DealStateEvent::DEAL_STATE_UPDATE_EVENT;
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($dealState, new DealStateMap());

        $event = new DealStateEvent();
        $event->setDealState($dealState);
        $dispatcher->dispatch($eventName, $event);

        if(false != $errors = $transformer->validate($dealState)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $dealStateManager->update($dealState);
            return new Response();
        }
    }
} 