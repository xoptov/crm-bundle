<?php

namespace Perfico\CRMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Perfico\CoreBundle\Entity\Deal;
use Perfico\CRMBundle\Transformer\Mapping\PaymentMap;
use Perfico\CRMBundle\Transformer\Mapping\DealMap;
use Perfico\CRMBundle\Transformer\Mapping\ProductMap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DealController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Deal",
     *  description="List of all deals for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/deals")
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_DEAL_VIEW_ALL', 'ROLE_DEAL_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $deals = $this->get('perfico_crm.deal_manager')->getAccountDeals();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($deals, new DealMap(), 'deals')
        );
    }

    /**
     * @ApiDoc(
     *  section="Deal",
     *  description="Get specified deal",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/deals/{id}")
     * @ParamConverter("deal", converter="account.doctrine.orm")
     * @param Deal $deal
     * @return JsonResponse|Response
     */
    public function getAction(Deal $deal)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_DEAL_VIEW_ALL', 'ROLE_DEAL_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($deal, new DealMap(), 'deals')
        );
    }

    /**
     * @ApiDoc(
     *  section="Deal",
     *  description="Get specified deal product",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/deals/{id}/product")
     * @ParamConverter("deal", converter="account.doctrine.orm")
     * @param Deal $deal
     * @return JsonResponse|Response
     */
    public function getProductAction(Deal $deal)
    {
        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($deal->getProduct(), new ProductMap(), 'products')
        );
    }

    /**
     * @ApiDoc(
     *  section="Deal",
     *  description="Create new deal",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="note", "dataType"="string", "required"=0},
     *    {"name"="product", "dataType"="integer", "required"=1},
     *    {"name"="amount", "dataType"="float", "required"=1},
     *    {"name"="state", "dataType"="integer", "required"=1},
     *    {"name"="client", "dataType"="integer", "required"=1},
     *    {"name"="user", "dataType"="integer", "required"=1}
     *   }
     * )
     * @Method("POST")
     * @Route("/deals")
     * @return Response|JsonResponse
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_DEAL_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Deal",
     *  description="Remove deal",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/deals/{id}")
     * @ParamConverter("deal", converter="account.doctrine.orm")
     * @param Deal $deal
     * @return Response
     */
    public function removeAction(Deal $deal)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_DEAL_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.deal_manager')->remove($deal);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Deal",
     *  description="Update deal details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="note", "dataType"="string", "required"=0},
     *    {"name"="product", "dataType"="integer", "required"=1},
     *    {"name"="amount", "dataType"="float", "required"=1},
     *    {"name"="state", "dataType"="integer", "required"=1},
     *    {"name"="client", "dataType"="integer", "required"=1},
     *    {"name"="user", "dataType"="integer", "required"=1}
     *   }
     * )
     * @Method("PUT")
     * @Route("/deals/{id}")
     * @ParamConverter("deal", converter="account.doctrine.orm")
     * @param Deal $deal
     * @return Response
     */
    public function updateAction(Deal $deal)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_DEAL_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($deal);
    }

    /**
     * @ApiDoc(
     *  section="Deal",
     *  description="Get all deals for client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/deals/{id}/payments")
     * @ParamConverter("deal", converter="account.doctrine.orm")
     * @param Deal $deal
     * @return JsonResponse
     */
    public function paymentsAction(Deal $deal)
    {
        $request = $this->get('request');

        $page = $request->get('page');
        $limit = $request->get('limit');

        if (!$page)
        {
            $page = 1;
        }

        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PAYMENT_VIEW_ALL', 'ROLE_PAYMENT_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $dealManager = $this->get('perfico_crm.deal_manager');

        $payments = $dealManager->getDealPayments($deal, $page, $limit);

        $items = $this->get('perfico_crm.api.transformer')
                    ->transformCollection($payments['items'], new PaymentMap(), 'payments');

        return new JsonResponse(
            [
                'items' => $items,
                'total' => $payments['count'],
                'page' => $page
            ]
        );
    }

    /**
     * Handle request for deal process
     * @param Deal $deal
     * @return JsonResponse|Response
     */
    protected function handleRequest(Deal $deal = null)
    {
        $dealManager = $this->get('perfico_crm.deal_manager');

        if(!$deal) {
            $deal = $dealManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($deal, new DealMap());

        if(false != $errors = $transformer->validate($deal)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $dealManager->update($deal);
            return new Response();
        }
    }
} 