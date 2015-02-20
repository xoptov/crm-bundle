<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\ActivityMap;
use Perfico\CoreBundle\Entity\Activity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

class ActivityController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Client Activity",
     *  description="List of all clients activity for account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/activities")
     * @return JsonResponse
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_ACTIVITY_VIEW_ALL', 'ROLE_ACTIVITY_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $activities = $this->get('perfico_crm.activity_manager')->getAccountActivities();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
            ->transformCollection($activities, new ActivityMap(), 'activities')
        );
    }

    /**
     * @ApiDoc(
     *  section="Client Activity",
     *  description="List of all activity types",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/activities/types")
     * @return JsonResponse
     */
    public function typesAction()
    {
        $activityTypes = $this->get('perfico_crm.activity_manager')->getActivityTypes();

        return new JsonResponse($activityTypes);
    }

    /**
     * @ApiDoc(
     *  section="Client Activity",
     *  description="Get specified client activity",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/activities/{id}")
     * @ParamConverter("activity", converter="account.doctrine.orm")
     * @param Activity $activity
     * @return JsonResponse
     */
    public function getAction(Activity $activity)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_ACTIVITY_VIEW_ALL', 'ROLE_ACTIVITY_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($activity, new ActivityMap(), 'activities')
        );
    }

    /**
     * @ApiDoc(
     *  section="Client Activity",
     *  description="Create new client activity for client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="type", "dataType"="string", "required"="true"},
     *    {"name"="note", "dataType"="string", "required"="false"},
     *    {"name"="rememberAt", "dataType"="datetime", "required"="false"},
     *    {"name"="client", "dataType"="integer", "required"="true"}
     *   }
     * )
     * @Method("POST")
     * @Route("/activities")
     * @return JsonResponse | Response
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_ACTIVITY_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Client Activity",
     *  description="Remove client activity",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/activities/{id}")
     * @ParamConverter("activity", converter="account.doctrine.orm")
     * @param Activity $activity
     * @return Response
     */
    public function removeAction(Activity $activity)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_ACTIVITY_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.activity_manager')->remove($activity);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Client Activity",
     *  description="Update client activity details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="type", "dataType"="string", "required"="true"},
     *    {"name"="note", "dataType"="string", "required"="false"},
     *    {"name"="rememberAt", "dataType"="datetime", "required"="false"}
     *   }
     * )
     * @Method("PUT")
     * @Route("/activities/{id}")
     * @ParamConverter("activity", converter="account.doctrine.orm")
     * @param Activity $activity
     * @return Response
     */
    public function updateAction(Activity $activity)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_ACTIVITY_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($activity);
    }

    protected function handleRequest(Activity $activity = null)
    {
        $clientActivityManager = $this->get('perfico_crm.activity_manager');

        if(!$activity) {
            $activity = $clientActivityManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($activity, new ActivityMap());

        if(false != $errors = $transformer->validate($activity)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $clientActivityManager->update($activity);
            return new Response();
        }
    }
}
