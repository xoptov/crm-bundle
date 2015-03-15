<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Search\CompanyCondition;
use Perfico\CRMBundle\Transformer\Mapping\CompanyMap;
use Perfico\CRMBundle\Transformer\Mapping\ActivityMap;
use Perfico\CoreBundle\Entity\Company;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Perfico\CRMBundle\Transformer\Mapping\CompanyConditionMap;

class CompanyController extends Controller
{
    /**
     * @ApiDoc(
     *  section="Company",
     *  description="List of all companies for current account",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * ),
     * @Method("GET")
     * @Route("/companies")
     */
    public function indexAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_COMPANY_VIEW_ALL', 'ROLE_COMPANY_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $companies = $this->get('perfico_crm.company_manager')->getAllCompanies();

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($companies, new CompanyMap(), 'companies')
        );
    }

    /**
     * @ApiDoc(
     *  section="Company",
     *  description="Get specified company",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/companies/{id}", requirements={"id":"\d+"})
     * @ParamConverter("company", converter="account.doctrine.orm")
     * @param Company $company
     * @return JsonResponse
     */
    public function getAction(Company $company)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($company, 'VIEW')) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transform($company, new CompanyMap(), 'companies')
        );
    }

    /**
     * @ApiDoc(
     *  section="Company",
     *  description="Search company by specified conditions",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=0},
     *      {"name"="dealFrom", "dataType"="DateTime", "required"=0},
     *      {"name"="dealTo", "dataType"="DateTime", "required"=0},
     *      {"name"="activityFrom", "dataType"="DateTime", "required"=0},
     *      {"name"="activityTo", "dataType"="DateTime", "required"=0},
     *      {"name"="tags", "dataType"="array", "readonly"=0, "required"=0, "children"={
     *          {"name"="id", "dataType"="integer", "required"=0, "description"="set only one tag id"}
     *      }},
     *      {"name"="dealStates", "dataType"="array", "readonly"=0, "required"=0, "children"={
     *          {"name"="id", "dataType"="integer", "required"=0, "description"="set only one deal state id"}
     *      }},
     *      {"name"="delayedPayment", "dataType"="boolean", "required"=0},
     *      {"name"="offset", "dataType"="integer", "required"=0},
     *      {"name"="limit", "dataType"="integer", "required"=0}
     *  }
     * )
     * @Method("GET")
     * @Route("/companies/search")
     * @return JsonResponse
     */
    public function searchAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_COMPANY_VIEW_ALL', 'ROLE_COMPANY_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $condition = new CompanyCondition();
        $condition->setAccount($this->get('perfico_crm.account_manager')->getCurrentAccount());

        $this->get('perfico_crm.api.reverse_transformer')->bind($condition, new CompanyConditionMap());
        $companies = $this->get('perfico_crm.company_manager')->search($condition);

        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($companies, new CompanyMap(), 'companies')
        );
    }

    /**
     * @ApiDoc(
     *  section="Company",
     *  description="Create new company",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"=1},
     *    {"name"="inn", "dataType"="integer", "required"=0},
     *    {"name"="phone", "dataType"="string", "required"=0},
     *    {"name"="details", "dataType"="string", "required"=0}
     *   }
     * )
     * @Method("POST")
     * @Route("/companies")
     */
    public function createAction()
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_COMPANY_ADD'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest();
    }

    /**
     * @ApiDoc(
     *  section="Company",
     *  description="Remove company",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("DELETE")
     * @Route("/companies/{id}")
     * @ParamConverter("company", converter="account.doctrine.orm")
     * @param Company $company
     * @return Response
     */
    public function removeAction(Company $company)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($company, 'REMOVE')) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        $this->get('perfico_crm.company_manager')->remove($company);

        return new Response();
    }

    /**
     * @ApiDoc(
     *  section="Company",
     *  description="Update company details",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"=0},
     *    {"name"="inn", "dataType"="integer", "required"=0},
     *    {"name"="phone", "dataType"="string", "required"=0},
     *    {"name"="details", "dataType"="string", "required"=0}
     *   }
     * )
     * @Method("PUT")
     * @Route("/companies/{id}")
     * @ParamConverter("company", converter="account.doctrine.orm")
     * @param Company $company
     * @return Response
     */
    public function updateAction(Company $company)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($company, 'EDIT')) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }

        return $this->handleRequest($company);
    }

    /**
     * @ApiDoc(
     *  section="Company",
     *  description="Get all activities for company",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  }
     * )
     * @Method("GET")
     * @Route("/companies/{id}/activities")
     * @ParamConverter("company", converter="account.doctrine.orm")
     * @param Company $company
     * @return JsonResponse
     */
    public function activitiesAction(Company $company)
    {
        if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_ACTIVITY_VIEW_ALL', 'ROLE_ACTIVITY_VIEW_OWN'])) {
            return new JsonResponse([], Response::HTTP_FORBIDDEN);
        }
        $activities = $this->get('perfico_crm.activity_manager')->getByCompany($company);
        return new JsonResponse(
            $this->get('perfico_crm.api.transformer')
                ->transformCollection($activities, new ActivityMap(), 'activities')
        );
    }

    /**
     * @param Company|null $company
     * @return JsonResponse|Response
     */
    protected function handleRequest(Company $company = null)
    {
        $companyManager = $this->get('perfico_crm.company_manager');

        if (!$company) {
            $company = $companyManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($company, new CompanyMap());

        if (false != $errors = $transformer->validate($company)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $companyManager->update($company);
            $company = $this->get('perfico_crm.api.transformer')
                ->transform($company, new CompanyMap(), 'companies');

            return new JsonResponse($company);
        }
    }
}
