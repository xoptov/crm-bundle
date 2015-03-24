<?php

namespace Perfico\CRMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Perfico\CoreBundle\Entity\Task;
use Perfico\CRMBundle\Transformer\Mapping\TaskMap;
use Perfico\CRMBundle\Transformer\Mapping\SubTaskMap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TaskController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Task",
     *  description="List of all tasks for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/tasks")
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TASK_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $tasks = $this->get('perfico_crm.task_manager')->getAccountTask();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($tasks, new TaskMap(), 'tasks')
        );
    }

    /**
     * @ApiDoc(
     *  section="Task",
     *  description="Get specified task",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/tasks/{id}", requirements={"id"="\d+"})
     * @ParamConverter("task", converter="account.doctrine.orm")
     * @param Task $task
     * @return JsonResponse|Response
     */
    public function getAction(Task $task)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TASK_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($task, new TaskMap(), 'tasks')
        );
    }

    /**
     * @ApiDoc(
     *  section="Task",
     *  description="Create new task",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"=1},
     *    {"name"="note", "dataType"="string", "required"=0},
     *    {"name"="deadLine", "dataType"="datetime", "required"=0},
     *    {"name"="rememberAt", "dataType"="datetime", "required"=0},
     *    {"name"="user", "dataType"="integer", "required"=0},
     *    {"name"="company", "dataType"="integer", "required"=0},
     *    {"name"="state", "dataType"="integer", "required"=0},
     *    {"name"="activities", "dataType"="array", "required"=0, "readonly"=0, "children"={
     *        {"name"="id", "dataType"="integer", "required"=0, "description"="set only activity id"}
     *      }
     *    }
     *   }
     * )
     * @Method("POST")
     * @Route("/tasks")
     * @return Response|JsonResponse
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TASK_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Task",
     *  description="Remove task",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/tasks/{id}")
     * @ParamConverter("task", converter="account.doctrine.orm")
     * @param Task $task
     * @return Response
     */
    public function removeAction(Task $task)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TASK_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.task_manager')->remove($task);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Task",
     *  description="Update task details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"=1},
     *    {"name"="note", "dataType"="string", "required"=0},
     *    {"name"="deadLine", "dataType"="datetime", "required"=0},
     *    {"name"="rememberAt", "dataType"="datetime", "required"=0},
     *    {"name"="user", "dataType"="integer", "required"=0},
     *    {"name"="company", "dataType"="integer", "required"=0},
     *    {"name"="state", "dataType"="integer", "required"=0},
     *    {"name"="activities", "dataType"="array", "required"=0, "readonly"=0, "children"={
     *        {"name"="id", "dataType"="integer", "required"=0, "description"="set only activity id"}
     *      }
     *    }
     *   }
     * )
     * @Method("PUT")
     * @Route("/tasks/{id}")
     * @ParamConverter("task", converter="account.doctrine.orm")
     * @param Task $task
     * @return Response
     */
    public function updateAction(Task $task)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_TASK_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($task);
    }

    /**
     * @ApiDoc(
     *  section="Task",
     *  description="Get specified sub task task",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/tasks/{id}/sub-tasks")
     * @ParamConverter("task", converter="account.doctrine.orm")
     * @param Task $task
     * @return JsonResponse|Response
     */
    public function getActionSubTask(Task $task)
    {
        $subTask = $this->get('perfico_crm.sub_task_manager')->getSubTaskForTask($task);
            return new JsonResponse(
                $this->get('perfico_crm.api.transformer')
                    ->transformCollection($subTask, new SubTaskMap(), 'subTask')
            );
    }

    /**
     * Handle request for task process
     * @param Task $task
     * @return JsonResponse|Response
     */
    protected function handleRequest(Task $task = null)
    {
        $taskManager = $this->get('perfico_crm.task_manager');

        if(!$task) {
            $task = $taskManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($task, new TaskMap());

        if(false != $errors = $transformer->validate($task)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $taskManager->update($task);
            return new Response();
        }
    }
}