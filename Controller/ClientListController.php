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
use Perfico\CRMBundle\Search\ClientCondition;
use Perfico\CRMBundle\Transformer\Mapping\ClientConditionMap;

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
     * @deprecated
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
     * @deprecated
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

    /**
     * @ApiDoc(
     *  section="List actions",
     *  description="List of clients for current account with params",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=0},
     *      {"name"="user", "dataType"="integer", "required"=0},
     *      {"name"="email", "dataType"="string", "required"=0},
     *      {"name"="phone", "dataType"="string", "required"=0},
     *      {"name"="channel", "dataType"="integer", "required"=0},
     *      {"name"="createdFrom", "dataType"="DateTime", "required"=0},
     *      {"name"="createdTo", "dataType"="DateTime", "required"=0},
     *      {"name"="dealFrom", "dataType"="DateTime", "required"=0},
     *      {"name"="dealTo", "dataType"="DateTime", "required"=0},
     *      {"name"="activityFrom", "dataType"="DateTime", "required"=0},
     *      {"name"="activityTo", "dataType"="DateTime", "required"=0},
     *      {"name"="dealStates", "dataType"="array", "required"=0, "readonly"=0, "children"={
     *          {"name"="id", "dataType"="integer", "required"=0, "description"="set only deal state id"}
     *      }},
     *      {"name"="tags", "dataType"="array", "required"=0, "readonly"=0, "children"={
     *          {"name"="id", "dataType"="integer", "required"=0, "description"="set only tag id"}
     *      }},
     *      {"name"="delayedPayment", "dataType"="boolean", "required"=0},
     *      {"name"="offset", "dataType"="integer", "required"=0},
     *      {"name"="limit", "dataType"="integer", "required"=0}
     *  }
     * )
     * @Method("GET")
     * @Route("/clients-list/search")
     * @return JsonResponse
     */
    public function searchAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CLIENT_VIEW_ALL', 'ROLE_CLIENT_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $conditions = new ClientCondition();
        $account = $this->get('perfico_crm.account_manager')->getCurrentAccount();
        $conditions->setAccount($account);

        $this->get('perfico_crm.api.reverse_transformer')->bind($conditions, new ClientConditionMap());
        $clients = $this->get('perfico_crm.client_manager')->search($conditions);

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($clients, new ClientsListMap(), 'clients'));
    }
}
