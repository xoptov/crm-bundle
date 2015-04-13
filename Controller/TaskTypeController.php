<?php

namespace Perfico\CRMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Perfico\CRMBundle\Transformer\Mapping\TaskTypeMap;
use Perfico\CoreBundle\Entity\TaskType;

class TaskTypeController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Task Types",
     *  description="List of all task types for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * ),
     * @Method("GET")
     * @Route("/task-types")
     * @return JsonResponse
     */
    public function indexAction()
    {
        $types = $this->get('perfico_crm.task_type_manager')->getAccountTaskTypes();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($types, new TaskTypeMap(), 'taskTypes')
        );
    }

    /**
     * @ApiDoc(
     *  section="Task Types",
     *  description="View task type",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/task-types/{id}", requirements={"id":"\d+"})
     * @param TaskType $taskType
     * @return JsonResponse
     */
    public function getAction(TaskType $taskType)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TASK_TYPE_VIEW_ALL'])) {
            return new JsonResponse([], 403);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($taskType, new TaskTypeMap(), 'taskTypes'));
    }

    /**
     * @ApiDoc(
     *  section="Task Types",
     *  description="Create new task type",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=1},
 *          {"name"="icon", "dataType"="string", "required"=1},
     *   }
     * )
     * @Method("POST")
     * @Route("/task-types")
     * @return JsonResponse
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TASK_TYPE_ADD'])) {
            return new JsonResponse([], 403);
        }

        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Task Types",
     *  description="Remove task type",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/task-types/{id}")
     * @param TaskType $taskType
     * @return Response
     */
    public function removeAction(TaskType $taskType)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($taskType, 'REMOVE')) {
            return new JsonResponse([], 403);
        }

        $this->get('perfico_crm.task_type_manager')->remove($taskType);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Task Types",
     *  description="Update task type details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=1},
     *      {"name"="icon", "dataType"="string", "required"=1},
     *   }
     * )
     * @Method("PUT")
     * @Route("/task-types/{id}")
     * @param TaskType $taskType
     * @return Response
     */
    public function updateAction(TaskType $taskType)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($taskType, 'EDIT')) {
            return new JsonResponse([], 403);
        }

        return $this->handleRequest($taskType);
    }

    /**
     * @param TaskType|null $taskType
     * @return JsonResponse|Response
     */
    protected function handleRequest(TaskType $taskType = null)
    {
        $taskTypeManager = $this->get('perfico_crm.task_type_manager');

        if(!$taskType) {
            $taskType = $taskTypeManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($taskType, new TaskTypeMap());

        if (false != $errors = $transformer->validate($taskType)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);

        } else {
            $taskTypeManager->update($taskType);

            $json = $this->get('perfico_crm.api.transformer')
                ->transform($taskType, new TaskTypeMap(), 'taskTypes');

            return new JsonResponse($json);
        }
    }
} 