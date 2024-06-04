<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SitioRepository;
use App\Repository\MenuRepository;


class AyudaController extends BaseController
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

    #[Route('/ayuda', name: 'ayuda')]
    public function index(): Response
    {
        return $this->renderWithMenu('ayuda/ayuda.html.twig', [
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }
}