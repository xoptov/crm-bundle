<?php

namespace Perfico\CRMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Perfico\CoreBundle\Entity\Payment;
use Perfico\CRMBundle\Transformer\Mapping\PaymentMap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PaymentController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Payment",
     *  description="List of all payments for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/payments")
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PAYMENT_VIEW_ALL', 'ROLE_PAYMENT_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $payments = $this->get('perfico_crm.payment_manager')->getAccountPayments();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($payments, new PaymentMap(), 'payments')
        );
    }

    /**
     * @ApiDoc(
     *  section="Payment",
     *  description="Get specified payment",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/payments/{id}")
     * @ParamConverter("payment", converter="account.doctrine.orm")
     * @param Payment $payment)
     * @return JsonResponse
     */
    public function getAction(Payment $payment)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PAYMENT_VIEW_ALL', 'ROLE_PAYMENT_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($payment, new PaymentMap(), 'payments')
        );
    }

    /**
     * @ApiDoc(
     *  section="Payment",
     *  description="Create new payment",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="note", "dataType"="string", "required"=0},
     *    {"name"="amount", "dataType"="float", "required"=1},
     *    {"name"="deal", "dataType"="integer", "required"=1}
     *   }
     * )
     * @Method("POST")
     * @Route("/payments")
     * @return JsonResponse|Response
     *
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PAYMENT_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Payment",
     *  description="Remove payment",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/payments/{id}")
     * @ParamConverter("payment", converter="account.doctrine.orm")
     * @param Payment $payment
     * @return Response
     */
    public function removeAction(Payment $payment)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PAYMENT_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.payment_manager')->remove($payment);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Payment",
     *  description="Update payment details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="note", "dataType"="string", "required"=0},
     *    {"name"="amount", "dataType"="float", "required"=1}
     *   }
     * )
     * @Method("PUT|PATCH")
     * @Route("/payments/{id}")
     * @ParamConverter("payment", converter="account.doctrine.orm")
     * @param Payment $payment
     * @return Response
     */
    public function updateAction(Payment $payment)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PAYMENT_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($payment);
    }

    /**
     * @param Payment|null $payment
     * @return JsonResponse|Response
     */
    protected function handleRequest(Payment $payment = null)
    {
        $paymentManager = $this->get('perfico_crm.payment_manager');

        if(!$payment) {
            $payment = $paymentManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($payment, new PaymentMap());

        if(false != $errors = $transformer->validate($payment)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $paymentManager->update($payment);
            return new Response();
        }
    }
} 