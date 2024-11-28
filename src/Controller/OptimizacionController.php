<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Menu;
use App\Repository\SitioRepository;
use App\Repository\MenuRepository;

#[Route('/optimizacion')]
class OptimizacionController extends BaseController
{
    private $sitio;
    private $menues;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository, MenuRepository $menuRepository)
    {
        parent::__construct($menuRepository);
        $this->entityManager = $entityManager;
        $this->sitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->menues = $menuRepository->findVisibleMenus();    }

        #[Route('/', name: 'index_optimizacion')]
        public function index_optimizacion(Request $request, SitioRepository $sitioRepository): Response
        {
        
            return $this->renderWithMenu('optimizacion/index.html.twig', [
                'sitio' => $this->sitio,
                'menues' => $this->menues,
            ]);
        }


    }