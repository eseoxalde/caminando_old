<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SitioRepository;
use App\Repository\MenuRepository;

class ErrorController extends BaseController
{
    private $entityManager;
    private $sitio;
    private $menuRepository;
    private $menues;

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository, MenuRepository $menuRepository)
    {
        parent::__construct($menuRepository);
        $this->entityManager = $entityManager;
        $this->sitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->menuRepository = $menuRepository;
        $this->menues = $menuRepository->findVisibleMenus();
    }

    #[Route('/error/404', name: 'error_404')]
    public function showError(): Response
    {
        return $this->render('error/404.html.twig',[
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }
}
