<?php

namespace Perfico\CRMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Perfico\CoreBundle\Entity\Call;
use Perfico\CRMBundle\Transformer\Mapping\CallMap;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CallController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Call",
     *  description="List of all calls",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/calls")
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CALL_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $calls = $this->get('perfico_crm.call_manager')->getCalls();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($calls, new CallMap(), 'calls')
        );
    }

    /**
     * @ApiDoc(
     *  section="Call",
     *  description="Get specified call",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/calls/{id}")
     * @ParamConverter("call", converter="account.doctrine.orm")
     * @param Call $call
     * @return JsonResponse|Response
     */
    public function getAction(Call $call)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CALL_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($call, new CallMap(), 'calls')
        );
    }

    /**
     * @ApiDoc(
     *  section="Call",
     *  description="Remove call",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/calls/{id}")
     * @ParamConverter("call", converter="account.doctrine.orm")
     * @param Call $call
     * @return Response
     */
    public function removeAction(Call $call)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CALL_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.call_manager')->remove($call);

        return new Response();
    }
} 