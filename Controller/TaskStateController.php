<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\TaskStateMap;
use Perfico\CoreBundle\Entity\TaskState;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TaskStateController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Task States",
     *  description="List of all task states for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/task-states")
     */
    public function indexAction()
    {
        $taskStates = $this->get('perfico_crm.task_state_manager')->getAccountTaskStates();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($taskStates, new TaskStateMap(), 'taskStates')
        );
    }

    /**
     * @ApiDoc(
     *  section="Task States",
     *  description="Get specified task state",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/task-states/{id}")
     * @ParamConverter("taskState", converter="account.doctrine.orm")
     * @param TaskState $taskState
     * @return JsonResponse|Response
     */
    public function getAction(TaskState $taskState)
    {
        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($taskState, new TaskStateMap(), 'taskStates')
        );
    }

    /**
     * @ApiDoc(
     *  section="Task States",
     *  description="Create new task state",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"=1}
     *   }
     * )
     * @Method("POST")
     * @Route("/task-states")
     * @return Response|JsonResponse
     */
    public function createAction()
    {
        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Task States",
     *  description="Remove task state",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/task-states/{id}")
     * @ParamConverter("taskState", converter="account.doctrine.orm")
     * @param TaskState $taskState
     * @return Response
     */
    public function removeAction(TaskState $taskState)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TASK_STATE_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.task_state_manager')->remove($taskState);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Task States",
     *  description="Update task state details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"=1}
     *   }
     * )
     * @Method("PUT|PATCH")
     * @Route("/task-states/{id}")
     * @ParamConverter("taskState", converter="account.doctrine.orm")
     * @param TaskState $taskState
     * @return Response
     */
    public function updateAction(TaskState $taskState)
    {
        return $this->handleRequest($taskState);
    }

    /**
     * Handle request for deal state process
     * @param TaskState $taskState
     * @return JsonResponse|Response
     */
    protected function handleRequest(TaskState $taskState = null)
    {
        $taskStateManager = $this->get('perfico_crm.task_state_manager');

        if(!$taskState) {
            $taskState = $taskStateManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($taskState, new TaskStateMap());

        if(false != $errors = $transformer->validate($taskState)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $taskStateManager->update($taskState);
            return new Response();
        }
    }
} 