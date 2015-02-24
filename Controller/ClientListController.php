<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\ClientsListMap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientListController extends Controller
{
    /**
     * @ApiDoc(
     *  section="List actions",
     *  description="List of all clients for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/clients-list")
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CLIENT_VIEW_OWN', 'ROLE_CLIENT_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }
        $securityContext = $this->get('security.context');
        $onlyForUser = $securityContext->isGranted('ROLE_CLIENT_VIEW_ALL') ? null : $this->getUser();

        $clients = $this->get('perfico_crm.client_manager')->getAccountClients($onlyForUser);

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
            ->transformCollection($clients, new ClientsListMap(), 'clients')
        );
    }

    /**
     * @ApiDoc(
     *  section="List actions",
     *  description="List of clients for current account with params",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="start", "dataType"="integer", "required"=1},
     *    {"name"="limit", "dataType"="integer", "required"=1}
     *   }
     * )
     * @Method("GET")
     * @Route("/clients-list/{page}/{limit}")
     * @param integer $page
     * @param integer $limit
     * @return JsonResponse
     */
    public function listAction($page, $limit)
    {
        if (!$page)
        {
            $page = 1;
        }

        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CLIENT_VIEW_OWN', 'ROLE_CLIENT_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $securityContext = $this->get('security.context');
        $onlyForUser = $securityContext->isGranted('ROLE_CLIENT_VIEW_ALL') ? null : $this->getUser();

        /** @var Request $request */
        $request = $this->get('request');
        $filter = json_decode($request->get('filter'));

        $clients = $this->get('perfico_crm.client_manager')->getAccountClientsPage(
            $page,
            $limit,
            $filter,
            $onlyForUser
        );

        $items = $this->get('perfico_crm.api.transformer')
            ->transformCollection($clients['items'], new ClientsListMap(), 'clients');

        return new JsonResponse(
            [
                'items' => $items,
                'total' => $clients['count'],
                'page' => $page
            ]
        );
    }
}
