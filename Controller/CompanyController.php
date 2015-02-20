<?php

namespace Perfico\CRMBundle\Controller;

use Perfico\CRMBundle\Transformer\Mapping\CompanyMap;
use Perfico\CoreBundle\Entity\Company;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

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
        $securityContext = $this->get('security.context');
        $onlyForUser = $securityContext->isGranted('ROLE_COMPANY_VIEW_ALL') ? null : $this->getUser();

        $companies = $this->get('perfico_crm.company_manager')->getAccountCompanies($onlyForUser);

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
     * @Route("/companies/{id}")
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
     *  description="Create new company",
     *  filters={
     *      {"name"="token", "type"="text"}
     *  },
     *  parameters={
     *    {"name"="name", "dataType"="string", "required"="false"}
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
     *    {"name"="name", "dataType"="string", "required"="false"}
     *   }
     * )
     * @Method("PUT")
     * @Route("/companies/{id}")
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
     * @param Company|null $company
     * @return JsonResponse|Response
     */
    protected function handleRequest(Company $company = null)
    {
        $companyManager = $this->get('perfico_crm.company_manager');

        if(!$company) {
            $company = $companyManager->create();
        }

        $transformer = $this->get('perfico_crm.api.reverse_transformer');
        $transformer->bind($company, new CompanyMap());

        if(false != $errors = $transformer->validate($company)) {

            return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {

            $companyManager->update($company);
            $company = $this->get('perfico_crm.api.transformer')
                ->transform($company, new CompanyMap(), 'companies');

            return new JsonResponse($company);
        }
    }
}
