<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SitioRepository;
use App\Repository\MenuRepository;

class TyCController extends BaseController
{
    private $entityManager;
    private $sitio;
    private $menues;

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository, MenuRepository $menuRepository)
    {
        parent::__construct($menuRepository);
        $this->entityManager = $entityManager;
        $this->sitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->menues = $menuRepository->findVisibleMenus();
    }

    #[Route('/terminos-condiciones', name: 'tyc')]
    public function index(): Response
    {
        return $this->renderWithMenu('tyc/index.html.twig', [
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }
}