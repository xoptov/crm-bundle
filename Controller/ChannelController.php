<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\ChannelMap;
use Perfico\CoreBundle\Entity\Channel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

class ChannelController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Channel",
     *  description="List of all channels for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/channels")
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CHANNEL_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $clients = $this->get('perfico_crm.channel_manager')->getAccountChannels();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($clients, new ChannelMap(), 'clients')
        );
    }

    /**
     * @ApiDoc(
     *  section="Channel",
     *  description="Get specified channel",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/channels/{id}")
     * @param Channel $channel
     * @return JsonResponse|Response
     */
    public function getAction(Channel $channel)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CHANNEL_VIEW_ALL'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($channel, new ChannelMap(), 'channels')
        );
    }

    /**
     * @ApiDoc(
     *  section="Channel",
     *  description="Create new channel",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"="true"},
     *   }
     * )
     * @Method("POST")
     * @Route("/channels")
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CHANNEL_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();

    }

    /**
     * @ApiDoc(
     *  section="Channel",
     *  description="Remove channel",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/channels/{id}")
     * @param Channel $channel
     * @return Response
     */
    public function removeAction(Channel $channel)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CHANNEL_REMOVE'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.channel_manager')->remove($channel);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Channel",
     *  description="Update channel details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"="true"},
     *   }
     * )
     * @Method("PUT")
     * @Route("/channels/{id}")
     * @param Channel $channel
     * @return Response
     */
    public function updateAction(Channel $channel)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_CHANNEL_EDIT'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($channel);
    }

    /**
     * @param Channel|null $channel
     * @return JsonResponse|Response
     */
    protected function handleRequest(Channel $channel = null)
    {
        $channelManager = $this->get('perfico_crm.channel_manager');

        if(!$channel) {
            $channel = $channelManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($channel, new ChannelMap());

        if(false != $errors = $transformer->validate($channel)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $channelManager->update($channel);
            return new Response();
        }
    }
} 