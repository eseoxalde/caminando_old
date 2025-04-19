<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Pagina;
use App\Repository\SitioRepository;
use App\Repository\PaginaRepository;
use App\Repository\MenuRepository;
use App\Repository\ForoRepository;
use App\Repository\CategoriaRepository;

use App\Form\PaginaType;
use App\Form\SitioType;
use App\Form\RedesType;
use App\Form\ForoType;

#[Route('/sitio')]
class SitioController extends BaseController
{
    private $entityManager;
    private $sitio;
    private $menues;

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository,  MenuRepository $menuRepository)
    {
        parent::__construct($menuRepository);
        $this->entityManager = $entityManager;
        $this->sitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->menues = $menuRepository->findVisibleMenus();
    }

    #[Route('/edit', name: 'sitio_edit')]
    public function edit_sitio(Request $request, SitioRepository $sitioRepository, PaginaRepository $paginaRepository): Response
    {
        $form = $this->createForm(SitioType::class, $this->sitio,);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $header = $form['header']->getData();
            if ($header) {
                $newFilename = uniqid() . '.' . $header->guessExtension();
                try {
                    $header->move(
                        $this->getParameter('app.logo_images_directory'),
                        $newFilename
                    );
                    $this->sitio->setHeader('/uploads/logo/' . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'No se pudo subir la imagen.');
                }
            }

            $logo = $form['logoSitio']->getData();
            if ($logo) {
                $newFilename = uniqid() . '.' . $logo->guessExtension();
                try {
                    $logo->move(
                        $this->getParameter('app.logo_images_directory'),
                        $newFilename
                    );
                    $this->sitio->setLogoSitio('/uploads/logo/' . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'No se pudo subir la imagen.');
                }
            }

            $this->entityManager->persist($this->sitio);
            $this->entityManager->flush();
            $this->addFlash('success', 'Sitio actualizado correctamente.');
            return $this->redirectToRoute('inicio');
        }

        $paginas = $paginaRepository->findAll();

        return $this->renderWithMenu('sitio/sitio_edit.html.twig', [
            'paginas' => $paginas, 
            'sitio' => $this->sitio,
            'form' => $form->createView(),
            'menues' => $this->menues,
        ]);
    }

    #[Route('/redes', name: 'redes_edit')]
    public function edit_redes(Request $request, SitioRepository $sitioRepository, PaginaRepository $paginaRepository, ForoRepository $foroRepository, CategoriaRepository $categoriaRepository): Response
    {
        $form = $this->createForm(RedesType::class, $this->sitio);
        $form->handleRequest($request);
    
        $foro = $foroRepository->findOneBy([], ['id' => 'ASC']);
        if (!$foro) {
            $this->addFlash('error', 'Configuración del foro no encontrada.');
            return $this->redirectToRoute('sitio_edit'); 
        }
    
        $foroForm = $this->createForm(ForoType::class, $foro);
        $foroForm->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($this->sitio);
            $this->entityManager->flush();
            $this->addFlash('success', 'Sitio actualizado correctamente.');
            return $this->redirectToRoute('redes_edit');
        }
    
        if ($foroForm->isSubmitted() && $foroForm->isValid()) {
            $this->entityManager->persist($foro);
            $this->entityManager->flush();
            $this->addFlash('success', 'Configuración del foro actualizada correctamente.');
            return $this->redirectToRoute('redes_edit'); 
        }

        $paginas = $paginaRepository->findAll();

        $categorias = $categoriaRepository->findAll();
    
        return $this->renderWithMenu('sitio/redes.html.twig', [
            'paginas' => $paginas,
            'sitio' => $this->sitio,
            'form' => $form->createView(),
            'menues' => $this->menues,
            'foroConfig' => $foro,
            'foroForm' => $foroForm->createView(),
            'categorias' => $categorias 
        ]);
    }
    
    
    
}
