<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CoreBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Perfico\CRMBundle\Transformer\Mapping\ContactMap;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ContactController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Contact",
     *  description="List of all contacts",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/contacts")
     * @return JsonResponse
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CONTACT_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $contacts = $this->get('perfico_crm.contact_manager')->getContacts();

        return new JsonResponse($this->get('perfico_crm.api.transformer')
                ->transformCollection($contacts, new ContactMap(), 'groups')
        );
    }

    /**
     * @ApiDoc(
     *  section="Contact",
     *  description="Get specified contact",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/contacts/{id}", requirements = {"id" = "\d+" })
     * @ParamConverter("contact", converter="account.doctrine.orm")
     * @param Contact $contact
     * @return JsonResponse
     */
    public function getAction(Contact $contact)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CONTACT_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($contact, new ContactMap(), 'groups')
        );
    }

    /**
     * @ApiDoc(
     *  section="Contact",
     *  description="Create new contact",
     *  parameters={
     *      {"name"="user", "dataType"="integer", "required"=1},
     *      {"name"="phone", "dataType"="string", "required"=1},
     *      {"name"="sip", "dataType"="string", "required"=0},
     *      {"name"="skype", "dataType"="string", "required"=0}
     *  },
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("POST")
     * @Route("/contacts")
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CONTACT_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();

    }

    /**
     * @ApiDoc(
     *  section="Contact",
     *  description="Remove contact",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/contacts/{id}")
     * @ParamConverter("contact", converter="account.doctrine.orm")
     * @param Contact $contact
     * @return Response
     */
    public function removeAction(Contact $contact)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CONTACT_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.contact_manager')->remove($contact);

        return new JsonResponse();
    }

    /**
     * @ApiDoc(
     *  section="Contact",
     *  description="Update contact details",
     *  parameters={
     *      {"name"="user", "dataType"="integer", "required"=1},
     *      {"name"="phone", "dataType"="string", "required"=1},
     *      {"name"="sip", "dataType"="string", "required"=0},
     *      {"name"="skype", "dataType"="string", "required"=0}
     *  },
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("PUT")
     * @Route("/contacts/{id}")
     * @ParamConverter("contact", converter="account.doctrine.orm")
     * @param Contact $contact
     * @return Response
     */
    public function updateAction(Contact $contact)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CONTACT_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($contact);
    }

    /**
     * @ApiDoc(
     *  section="Contact",
     *  description="Update contact details",
     *  parameters={
     *      {"name"="user", "dataType"="integer", "required"=1},
     *      {"name"="phone", "dataType"="string", "required"=1},
     *      {"name"="sip", "dataType"="string", "required"=0},
     *      {"name"="skype", "dataType"="string", "required"=0}
     *  },
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("PATCH")
     * @Route("/contacts/{id}")
     * @ParamConverter("contact", converter="account.doctrine.orm")
     * @param Contact $contact
     * @return Response
     */
    public function patchAction(Contact $contact)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CONTACT_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($contact);
    }

    /**
     * @param Contact|null $contact
     * @return JsonResponse|Response
     */
    protected function handleRequest($contact = null)
    {
        $contactManager = $this->get('perfico_crm.contact_manager');

        if(!$contact) {
            $contact = $contactManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($contact, new ContactMap());

        if(false != $errors = $transformer->validate($contact)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $contactManager->update($contact);

            return new JsonResponse($this->get('perfico_crm.api.transformer')
                ->transform($contact, new ContactMap(), 'contacts'));
        }
    }
}