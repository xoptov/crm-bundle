<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\SubTaskMap;
use Perfico\CoreBundle\Entity\SubTask;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SubTaskController extends Controller
{
    /**
     * @ApiDoc(
     *  section="SubTask",
     *  description="List of all sub-tasks for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/sub-tasks")
     */
    public function indexAction()
    {
        $subTask = $this->get('perfico_crm.sub_task_manager')->getAccountSubTask();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($subTask, new SubTaskMap(), 'subTask')
        );
    }

    /**
     * @ApiDoc(
     *  section="SubTask",
     *  description="Get specified sub-task",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/sub-tasks/{id}")
     * @ParamConverter("subTask", converter="account.doctrine.orm")
     * @param SubTask $subTask
     * @return JsonResponse|Response
     */
    public function getAction(SubTask $subTask)
    {
        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($subTask, new SubTaskMap(), 'subTask')
        );
    }

    /**
     * @ApiDoc(
     *  section="SubTask",
     *  description="Create new sub-task",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="task", "dataType"="integer", "required"=1},
     *    {"name"="note", "dataType"="string", "required"=1},
     *    {"name"="completed", "dataType"="boolean", "required"=0}
     *   }
     * )
     * @Method("POST")
     * @Route("/sub-tasks")
     * @return Response|JsonResponse
     */
    public function createAction()
    {
        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="SubTask",
     *  description="Remove sub-task",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/sub-tasks/{id}")
     * @ParamConverter("subTask", converter="account.doctrine.orm")
     * @param SubTask $subTask
     * @return Response
     */
    public function removeAction(SubTask $subTask)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_SUB_TASK_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.sub_task_manager')->remove($subTask);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="SubTask",
     *  description="Update sub-task details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="task", "dataType"="integer", "required"=1},
     *    {"name"="note", "dataType"="string", "required"=1},
     *    {"name"="completed", "dataType"="boolean", "required"=0}
     *   }
     * )
     * @Method("PUT")
     * @Route("/sub-tasks/{id}")
     * @ParamConverter("subTask", converter="account.doctrine.orm")
     * @param SubTask $subTask
     * @return Response
     */
    public function updateAction(SubTask $subTask)
    {
        return $this->handleRequest($subTask);
    }

    /**
     * @ApiDoc(
     *  section="SubTask",
     *  description="Update sub-task details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="task", "dataType"="integer", "required"=1},
     *    {"name"="note", "dataType"="string", "required"=1},
     *    {"name"="completed", "dataType"="boolean", "required"=0}
     *   }
     * )
     * @Method("PATCH")
     * @Route("/sub-tasks/{id}")
     * @ParamConverter("subTask", converter="account.doctrine.orm")
     * @param SubTask $subTask
     * @return Response
     */
    public function patchAction(SubTask $subTask)
    {
        return $this->handleRequest($subTask);
    }

    /**
     * Handle request for deal state process
     * @param SubTask $subTask
     * @return JsonResponse|Response
     */
    protected function handleRequest(SubTask $subTask = null)
    {
        $subTaskManager = $this->get('perfico_crm.sub_task_manager');

        if(!$subTask) {
            $subTask = $subTaskManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($subTask, new SubTaskMap());

        if(false != $errors = $transformer->validate($subTask)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $subTaskManager->update($subTask);
            return new Response();
        }
    }
}