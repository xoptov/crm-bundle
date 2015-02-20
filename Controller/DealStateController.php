<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\DealStateMap;
use Perfico\CoreBundle\Entity\DealState;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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
     * @param DealState $dealState
     * @return JsonResponse|Response
     */
    public function getAction( DealState $dealState)
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
     *    {"name"="name", "dataType"="string", "required"="true"},
     *    {"name"="icon", "dataType"="string", "required"="true"},
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
     *  }
     * )
     * @Method("DELETE")
     * @Route("/deal-states/{id}")
     * @param DealState $dealState
     * @return Response
     */
    public function removeAction(DealState $dealState)
    {
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
     *    {"name"="name", "dataType"="string", "required"="true"},
     *    {"name"="icon", "dataType"="string", "required"="true"}
     *   }
     * )
     * @Method("PUT")
     * @Route("/deal-states/{id}")
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

        if(!$dealState) {
            $dealState = $dealStateManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($dealState, new DealStateMap());

        if(false != $errors = $transformer->validate($dealState)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $dealStateManager->update($dealState);
            return new Response();
        }
    }
} 