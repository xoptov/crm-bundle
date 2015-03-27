<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\CustomFieldMap;
use Perfico\CoreBundle\Entity\CustomField;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CustomFieldController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Custom Fields",
     *  description="List of all custom fields for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/custom-fields")
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CUSTOM_FIELD_VIEW_ALL', 'ROLE_CUSTOM_FIELD_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $deals = $this->get('perfico_crm.custom_field_manager')->getAccountCustomFields();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($deals, new CustomFieldMap(), 'customFields')
        );
    }

    /**
     * @ApiDoc(
     *  section="Custom Fields",
     *  description="Get specified custom field",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/custom-fields/{id}")
     * @ParamConverter("customField", converter="account.doctrine.orm")
     * @param CustomField $customField
     * @return JsonResponse
     */
    public function getAction(CustomField $customField)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CUSTOM_FIELD_VIEW_ALL', 'ROLE_CUSTOM_FIELD_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($customField, new CustomFieldMap(), 'customFields')
        );
    }

    /**
     * @ApiDoc(
     *  section="Custom Fields",
     *  description="Create new custom field",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"=0},
     *    {"name"="number", "dataType"="integer", "required"=0}
     *   }
     * )
     * @Method("POST")
     * @Route("/custom-fields")
     * @return Response|JsonResponse
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CUSTOM_FIELD_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Custom Fields",
     *  description="Remove custom field",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/custom-fields/{id}")
     * @ParamConverter("customField", converter="account.doctrine.orm")
     * @param CustomField $customField
     * @return Response
     */
    public function removeAction(CustomField $customField)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CUSTOM_FIELD_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.custom_field_manager')->remove($customField);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Custom Fields",
     *  description="Update custom field details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"=0},
     *    {"name"="number", "dataType"="integer", "required"=0}
     *   }
     * )
     * @Method("PUT|PATCH")
     * @Route("/custom-fields/{id}")
     * @ParamConverter("customField", converter="account.doctrine.orm")
     * @param CustomField $customField
     * @return Response
     */
    public function updateAction(CustomField $customField)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CUSTOM_FIELD_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($customField);
    }

    /**
     * Handle request for custom field process
     * @param CustomField $customField
     * @return JsonResponse|Response
     */
    protected function handleRequest(CustomField $customField = null)
    {
        $manager = $this->get('perfico_crm.custom_field_manager');

        if(!$customField) {
            $customField = $manager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($customField, new CustomFieldMap());

        if(false != $errors = $transformer->validate($customField)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $manager->update($customField);
            return new Response();
        }
    }
} 