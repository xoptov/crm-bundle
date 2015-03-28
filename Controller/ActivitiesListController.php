<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CoreBundle\Entity\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Perfico\CRMBundle\Transformer\Mapping\ActivityListMap;

class ActivitiesListController extends Controller
{
    /**
     * @ApiDoc(
     *  section="List actions",
     *  description="List of all activities for specified client",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/clients/{id}/activities-list")
     * @param Client $client
     * @ParamConverter("client", converter="account.doctrine.orm")
     * @return JsonResponse
     */
    public function activitiesAction(Client $client)
    {
        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($client->getActivities(), new ActivityListMap(), 'activities')
        );
    }

}
