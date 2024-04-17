<?php

namespace App\Controller;

use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CompanyController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function getCompaniesAction(CompanyRepository $companyRepository): Response
    {
        $companySalesSummaries = $companyRepository->fetchAllCompaniesSalesSummary();

        return $this->render('company/summary.html.twig', [
            'companySalesSummaries' => $companySalesSummaries,
        ]);
    }

    #[Route('api/companies', name: 'api_app_companies', methods: ['GET'])]
    public function getCompaniesApiAction(CompanyRepository $companyRepository): Response
    {
        return $this->json($companyRepository->fetchAll());
    }

    #[Route('api/company/{companyId}/sales', name: 'app_company_sales', methods: ['GET'])]
    public function getCompanySalesAction(int $companyId, CompanyRepository $companyRepository): Response
    {
        return $this->json($companyRepository->fetchCompanySalesSummary($companyId));

    }
}
