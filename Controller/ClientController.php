<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Search\ClientCondition;
use Perfico\CRMBundle\Transformer\Mapping\ActivityMap;
use Perfico\CRMBundle\Transformer\Mapping\ClientCustomFieldMap;
use Perfico\CRMBundle\Transformer\Mapping\ClientConditionMap;
use Perfico\CRMBundle\Transformer\Mapping\DealMap;
use Perfico\CRMBundle\Transformer\Mapping\PhoneMap;
use Perfico\CRMBundle\Transformer\Mapping\ClientMap;
use Perfico\CoreBundle\Entity\Client;
use Perfico\CRMBundle\Transformer\Mapping\CallMap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ClientController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Client",
     *  description="List of all clients for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * ),
     * @Method("GET")
     * @Route("/clients")
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CLIENT_VIEW_ALL', 'ROLE_CLIENT_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }
        $securityContext = $this->get('security.context');
        $onlyForUser = $securityContext->isGranted('ROLE_CLIENT_VIEW_ALL') ? null : $this->getUser();

        $clients = $this->get('perfico_crm.client_manager')->getAccountClients($onlyForUser);

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
            ->transformCollection($clients, new ClientMap(), 'clients')
        );
    }

    /**
     * @ApiDoc(
     *  section="Client",
     *  description="Search clients by some parameters",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=0},
     *      {"name"="user", "dataType"="integer", "required"=0},
     *      {"name"="email", "dataType"="string", "required"=0},
     *      {"name"="emailNotSpecified", "dataType"="boolean", "required"=0},
     *      {"name"="phone", "dataType"="string", "required"=0},
     *      {"name"="phoneNotSpecified", "dataType"="boolean", "required"=0},
     *      {"name"="channel", "dataType"="integer", "required"=0},
     *      {"name"="company", "dataType"="integer", "required"=0},
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
     * @Route("/clients/search")
     * @return JsonResponse
     */
    public function searchAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CLIENT_VIEW_ALL', 'ROLE_CLIENT_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $condition = new ClientCondition();
        $account = $this->get('perfico_crm.account_manager')->getCurrentAccount();
        $condition->setAccount($account);

        $this->get('perfico_crm.api.reverse_transformer')->bind($condition, new ClientConditionMap());
        $clients = $this->get('perfico_crm.client_manager')->search($condition);

        $result = [
            'items' => $this->get('perfico_crm.api.transformer')->transformCollection($clients, new ClientMap(), 'clients'),
            'total' => $this->get('perfico_crm.client_manager')->resultCount($condition)
        ];

        return new JsonResponse($result);
    }

    /**
     * @ApiDoc(
     *  section="Client",
     *  description="Get specified client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/clients/{id}", requirements={"id":"\d+"})
     * @ParamConverter("client", converter="account.doctrine.orm")
     * @param Client $client
     * @return JsonResponse
     */
    public function readAction(Client $client)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($client, 'VIEW')) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($client, new ClientMap(), 'clients')
        );
    }

    /**
     * @ApiDoc(
     *  section="Client",
     *  description="Get all deals for client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/clients/{id}/deals")
     * @ParamConverter("client", converter="account.doctrine.orm")
     * @param Client $client
     * @return JsonResponse
     */
    public function dealsAction(Client $client)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_DEAL_VIEW_ALL', 'ROLE_DEAL_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($client->getDeals(), new DealMap(), 'deals')
        );
    }

    /**
     * @ApiDoc(
     *  section="Client",
     *  description="Get all activities for client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/clients/{id}/activities")
     * @ParamConverter("client", converter="account.doctrine.orm")
     * @param Client $client
     * @return JsonResponse
     */
    public function activitiesAction(Client $client)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_ACTIVITY_VIEW_ALL', 'ROLE_ACTIVITY_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($client->getActivities(), new ActivityMap(), 'activities')
        );
    }

    /**
     * @ApiDoc(
     *  section="Client",
     *  description="Get all phones for client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/clients/{id}/phones")
     * @ParamConverter("client", converter="account.doctrine.orm")
     * @param Client $client
     * @return JsonResponse
     */
    public function phonesAction(Client $client)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PHONE_VIEW_ALL', 'ROLE_PHONE_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($client->getPhones(), new PhoneMap(), 'phones'));
    }

    /**
     * @ApiDoc(
     *  section="Client",
     *  description="Get all calls for client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/clients/{id}/calls")
     * @ParamConverter("client", converter="account.doctrine.orm")
     * @param Client $client
     * @return JsonResponse
     */
    public function callsAction(Client $client)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CALL_VIEW_ALL', 'ROLE_CALL_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $calls = $this->get('perfico_crm.call_manager')->getClientCalls($client);

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($calls, new CallMap(), 'calls')
        );
    }

    /**
     * @ApiDoc(
     *  section="Client",
     *  description="Create new client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="firstName", "dataType"="string", "required"=1},
     *    {"name"="middleName", "dataType"="string", "required"=0},
     *    {"name"="lastName", "dataType"="string", "required"=0},
     *    {"name"="email", "dataType"="string", "required"=1},
     *    {"name"="skype", "dataType"="string", "required"=0},
     *    {"name"="note", "dataType"="string", "required"=0},
     *    {"name"="channel", "dataType"="integer", "required"=0},
     *    {"name"="company", "dataType"="integer", "required"=0},
     *    {"name"="position", "dataType"="string", "required"=0},
     *    {"name"="customField1", "dataType"="string", "required"=0},
     *    {"name"="customField2", "dataType"="string", "required"=0},
     *    {"name"="customField3", "dataType"="string", "required"=0},
     *    {"name"="customField4", "dataType"="string", "required"=0},
     *    {"name"="customField5", "dataType"="string", "required"=0},
     *    {"name"="customField6", "dataType"="string", "required"=0},
     *    {"name"="customField7", "dataType"="string", "required"=0},
     *    {"name"="customField8", "dataType"="string", "required"=0},
     *    {"name"="customField9", "dataType"="string", "required"=0},
     *    {"name"="customField10", "dataType"="string", "required"=0},
     *    {"name"="customField11", "dataType"="string", "required"=0},
     *    {"name"="customField12", "dataType"="string", "required"=0},
     *    {"name"="customField13", "dataType"="string", "required"=0},
     *    {"name"="customField14", "dataType"="string", "required"=0},
     *    {"name"="customField15", "dataType"="string", "required"=0},
     *    {"name"="tags", "dataType"="array", "required"=0, "readonly"=0, "children"={
     *        {"name"="id", "dataType"="integer", "required"=0, "description"="set only tag id"}
     *      }
     *    }
     *  }
     * )
     * @Method("POST")
     * @Route("/clients")
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CLIENT_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Client",
     *  description="Create new or update existed client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="firstName", "dataType"="string", "required"=1},
     *    {"name"="middleName", "dataType"="string", "required"=0},
     *    {"name"="lastName", "dataType"="string", "required"=0},
     *    {"name"="email", "dataType"="string", "required"=1},
     *    {"name"="skype", "dataType"="string", "required"=0},
     *    {"name"="note", "dataType"="string", "required"=0},
     *    {"name"="channel", "dataType"="integer", "required"=0},
     *    {"name"="company", "dataType"="integer", "required"=0},
     *    {"name"="position", "dataType"="string", "required"=0},
     *    {"name"="customField1", "dataType"="string", "required"=0},
     *    {"name"="customField2", "dataType"="string", "required"=0},
     *    {"name"="customField3", "dataType"="string", "required"=0},
     *    {"name"="customField4", "dataType"="string", "required"=0},
     *    {"name"="customField5", "dataType"="string", "required"=0},
     *    {"name"="customField6", "dataType"="string", "required"=0},
     *    {"name"="customField7", "dataType"="string", "required"=0},
     *    {"name"="customField8", "dataType"="string", "required"=0},
     *    {"name"="customField9", "dataType"="string", "required"=0},
     *    {"name"="customField10", "dataType"="string", "required"=0},
     *    {"name"="customField11", "dataType"="string", "required"=0},
     *    {"name"="customField12", "dataType"="string", "required"=0},
     *    {"name"="customField13", "dataType"="string", "required"=0},
     *    {"name"="customField14", "dataType"="string", "required"=0},
     *    {"name"="customField15", "dataType"="string", "required"=0},
     *    {"name"="tags", "dataType"="array", "required"=0, "readonly"=0, "children"={
     *      {"name"="id", "dataType"="integer", "required"=0, "description"="set only tag id"}
     *    }}
     *   }
     * )
     * @Method("POST")
     * @Route("/clients/create-or-update")
     * @deprecated will be removed in feature
     */
    public function createOrUpdateAction()
    {
        $request = $this->get('request');

        $accountManager = $this->get('perfico_crm.account_manager');

        $client = $this->getDoctrine()->getRepository('CoreBundle:Client')->findOneBy([
            'email'   => $request->get('email'),
            'account' => $accountManager->getCurrentAccount()
        ]);

        if($client instanceof Client)
        {
            if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CLIENT_EDIT'])) {
                return new JsonResponse([], Response::HTTP_FORBIDDEN);
            }
            return $this->handleRequest($client);
        }
        else
        {
            if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CLIENT_ADD'])) {
                return new JsonResponse([], Response::HTTP_FORBIDDEN);
            }
            return $this->handleRequest();
        }
    }

    /**
     * @ApiDoc(
     *  section="Client",
     *  description="Remove client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/clients/{id}")
     * @ParamConverter("client", converter="account.doctrine.orm")
     * @param Client $client
     * @return Response
     */
    public function removeAction(Client $client)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($client, 'REMOVE')) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.client_manager')->remove($client);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Client",
     *  description="Update client details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="firstName", "dataType"="string", "required"=1},
     *    {"name"="middleName", "dataType"="string", "required"=0},
     *    {"name"="lastName", "dataType"="string", "required"=0},
     *    {"name"="email", "dataType"="string", "required"=1},
     *    {"name"="skype", "dataType"="string", "required"=0},
     *    {"name"="note", "dataType"="string", "required"=0},
     *    {"name"="channel", "dataType"="integer", "required"=0},
     *    {"name"="company", "dataType"="integer", "required"=0},
     *    {"name"="position", "dataType"="string", "required"=0},
     *    {"name"="customField1", "dataType"="string", "required"=0},
     *    {"name"="customField2", "dataType"="string", "required"=0},
     *    {"name"="customField3", "dataType"="string", "required"=0},
     *    {"name"="customField4", "dataType"="string", "required"=0},
     *    {"name"="customField5", "dataType"="string", "required"=0},
     *    {"name"="customField6", "dataType"="string", "required"=0},
     *    {"name"="customField7", "dataType"="string", "required"=0},
     *    {"name"="customField8", "dataType"="string", "required"=0},
     *    {"name"="customField9", "dataType"="string", "required"=0},
     *    {"name"="customField10", "dataType"="string", "required"=0},
     *    {"name"="customField11", "dataType"="string", "required"=0},
     *    {"name"="customField12", "dataType"="string", "required"=0},
     *    {"name"="customField13", "dataType"="string", "required"=0},
     *    {"name"="customField14", "dataType"="string", "required"=0},
     *    {"name"="customField15", "dataType"="string", "required"=0},
     *    {"name"="tags", "dataType"="array", "required"=0, "readonly"=0, "children"={
     *        {"name"="id", "dataType"="integer", "required"=0, "description"="set only tag id"}
     *      }
     *    }
     *   }
     * )
     * @Method("PUT")
     * @Route("/clients/{id}")
     * @ParamConverter("client", converter="account.doctrine.orm")
     * @param Client $client
     * @return Response
     */
    public function updateAction(Client $client)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($client, 'EDIT')) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($client);
    }

    /**
     * @ApiDoc(
     *  section="Client",
     *  description="Update client custom field",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="number", "dataType"="integer", "required"=1},
     *    {"name"="value", "dataType"="string", "required"=0}
     *   }
     * )
     * @Method("PUT")
     * @Route("/clients-custom-field/{id}")
     * @ParamConverter("client", converter="account.doctrine.orm")
     * @param Client $client
     * @return Response
     * @todo непонятно зачем пладить одинаковый код? нужно переделать в будущем
     * @deprecated will be removed in the feature
     */
    public function updateCustomFieldAction(Client $client)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($client, 'EDIT')) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        /** @TODO временно, переделать в нормальной версии */
        $clientManager = $this->get('perfico_crm.client_manager');

        /** @var Request $request */
        $request = $this->get('request');

        $number = $request->get('number');
        $value = $request->get('value');

        $setCustomFieldFunc = 'setCustomField'.$number;
        $client->$setCustomFieldFunc($value);

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($client, new ClientCustomFieldMap());

        if(false != $errors = $transformer->validate($client)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $clientManager->update($client);
            $client = $this->get('perfico_crm.api.transformer')
                ->transform($client, new ClientCustomFieldMap(), 'customFields');
            return new JsonResponse($client);
        }
    }

    /**
     * @param Client|null $client
     * @return JsonResponse|Response
     */
    protected function handleRequest(Client $client = null)
    {
        $clientManager = $this->get('perfico_crm.client_manager');

        if(!$client) {
            $client = $clientManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($client, new ClientMap());

        if(false != $errors = $transformer->validate($client)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $clientManager->update($client);
            $client = $this->get('perfico_crm.api.transformer')
                ->transform($client, new ClientMap(), 'clients');

            return new JsonResponse($client);
        }
    }
}
