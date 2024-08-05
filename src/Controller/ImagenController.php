<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Menu;
use App\Repository\SitioRepository;
use App\Repository\MenuRepository;
use App\Repository\ImagenRepository;

#[Route('/imagen')]
class ImagenController extends BaseController
{
    private $sitio;
    private $menues;
    private $entityManager;
    private $imagenRepository;

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository, MenuRepository $menuRepository, ImagenRepository $imagenRepository)
    {
        parent::__construct($menuRepository);
        $this->entityManager = $entityManager;
        $this->sitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->menues = $menuRepository->findVisibleMenus();
        $this->imagenRepository = $imagenRepository; 
    }

    #[Route('/', name: 'app_imagen')]
    public function index(): Response
    {
        $imagenes = $this->imagenRepository->findAll();
        return $this->renderWithMenu('imagen/index.html.twig', [
            'sitio' => $this->sitio,
            'menues' => $this->menues,
            'imagenes'=>$imagenes,
        ]);
    }

    #[Route('/{id}/delete', name: 'imagen_delete', methods: ['POST'])]
    public function delete(Request $request, Imagen $imagen, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imagen->getId(), $request->request->get('_token'))) {
            $entityManager->remove($imagen);
            $entityManager->flush();
        }

        return $this->redirectToRoute('carpeta_show', ['id' => $imagen->getCarpeta()->getId()]);
    }

    private function delete_form(Imagen $imagen)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imagen_delete', ['id' => $imagen->getId()]))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
