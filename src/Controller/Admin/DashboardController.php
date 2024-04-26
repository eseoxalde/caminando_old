<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Pagina;
use App\Entity\Sitio;
use App\Entity\User;

class DashboardController extends AbstractDashboardController
{


     #[Route('/admin', name: 'admin')]
     #[IsGranted('ROLE_ADMIN')]
     public function index(): Response
     {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(SitioCrudController::class)->generateUrl());
     }

     public function configureDashboard(): Dashboard
     {
         return Dashboard::new()
            ->setTitle('Panel de administración')
            ->setFaviconPath('img/index/logo.ico')
            ->setTranslationDomain('admin');
     }

     public function configureMenuItems(): iterable
     {
         yield MenuItem::linktoRoute('Volver al sitio de Caminando', 'fas fa-home', 'inicio');
         yield MenuItem::linkToCrud('Sitio', 'fas fa-comments', Sitio::class);
         yield MenuItem::linkToCrud('Paginas', 'fas fa-file-text', Pagina::class);
         yield MenuItem::linkToCrud('Usuarios', 'fas fa-tags', User::class);
     }


}
