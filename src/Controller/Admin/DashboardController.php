<?php

namespace App\Controller\Admin;

use App\Entity\AccessToken;
use App\Entity\Company;
use App\Entity\Sale;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(CompanyCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BindHQ')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Access Tokens', 'fa fa-list', AccessToken::class);
        yield MenuItem::linkToCrud('Companies', 'fa fa-list', Company::class);
        yield MenuItem::linkToCrud('Sales', 'fa fa-list', Sale::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-list', User::class);
    }
}
