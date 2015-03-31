<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CoreBundle\Entity\Phone;
use Perfico\CoreBundle\Entity\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Perfico\CRMBundle\Transformer\Mapping\PhoneMap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PhoneController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Phone",
     *  description="List of all phones for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/phones")
     */
    public function indexAction()
    {
        $phones = $this->get('perfico_crm.phone_manager')->getAccountPhones();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($phones, new PhoneMap(), 'phones')
        );
    }

    /**
     * @ApiDoc(
     *  section="Phone",
     *  description="List of all phones for specified client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/phones/client/{id}", requirements={"id" = "\d+"})
     * @ParamConverter("client", converter="account.doctrine.orm")
     * @deprecated will be removed in the feature
     */
    public function getClientPhonesAction(Client $client)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PHONE_VIEW_ALL', 'ROLE_PHONE_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $phones = $client->getPhones();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($phones, new PhoneMap(), 'phones')
        );
    }

    /**
     * @ApiDoc(
     *  section="Phone",
     *  description="Get specified phone",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Route("/phones/{id}", requirements={"id" = "\d+"})
     * @ParamConverter("phone", converter="account.doctrine.orm")
     * @Method("GET")
     * @param Phone $phone
     * @return JsonResponse;
     */
    public function getAction(Phone $phone)
    {
        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($phone, new PhoneMap(), 'phones')
        );
    }

    /**
     * @ApiDoc(
     *  section="Phone",
     *  description="Create new phone for client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *      {"name"="number", "dataType"="string", "required"=0},
     *      {"name"="client", "dataType"="integer", "required"=0}
     *  }
     * )
     * @Method("POST")
     * @Route("/phones")
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PHONE_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();

    }

    /**
     * @ApiDoc(
     *  section="Phone",
     *  description="Create new phone for client",
     *  parameters={
     *    {"name"="phone", "dataType"="string", "required"=1},
     *    {"name"="client", "dataType"="integer", "required"=1}
     *  },
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("POST")
     * @Route("/phones/external")
     * @deprecated will be removed in the feature
     */
    public function createExternalAction()
    {
        $phoneManager = $this->get('perfico_crm.phone_manager');
        $clientRepo = $this->getDoctrine()->getRepository('CoreBundle:Client');

        $number = $this->get('request')->get('number');
        $clientId = $this->get('request')->get('client');

        $phone = $phoneManager->clientPhone($clientRepo->find($clientId), $number);

        if(count($phone) > 0)
        {
            return new Response();
        }

        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Phone",
     *  description="Remove phone",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/phones/{id}")
     * @ParamConverter("phone", converter="account.doctrine.orm")
     * @param Phone $phone
     * @return Response
     */
    public function removeAction(Phone $phone)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PHONE_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.phone_manager')->remove($phone);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Phone",
     *  description="Update phone details",
     *  input="Perfico\CoreBundle\Entity\Phone",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("PUT")
     * @Route("/phones/{id}")
     * @ParamConverter("phone", converter="account.doctrine.orm")
     * @param Phone $phone
     * @return Response
     */
    public function updateAction(Phone $phone)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PHONE_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($phone);
    }

    /**
     * @ApiDoc(
     *  section="Phone",
     *  description="Update phone details",
     *  input="Perfico\CoreBundle\Entity\Phone",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("PATCH")
     * @Route("/phones/{id}")
     * @ParamConverter("phone", converter="account.doctrine.orm")
     * @param Phone $phone
     * @return Response
     */
    public function patchAction(Phone $phone)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_PHONE_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($phone);
    }

    /**
     * @param Phone|null $phone
     * @return JsonResponse|Response
     */
    protected function handleRequest(Phone $phone = null)
    {
        $phoneManager = $this->get('perfico_crm.phone_manager');

        if(!$phone) {
            $phone = $phoneManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($phone, new PhoneMap());

        if(false != $errors = $transformer->validate($phone)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $phoneManager->update($phone);
            return new Response();
        }
    }
} 