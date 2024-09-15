<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Pagina;
use App\Entity\Menu;
use App\Repository\SitioRepository;
use App\Repository\PaginaRepository;
use App\Repository\MenuRepository;
use App\Repository\CarpetaRepository;
use App\Form\PaginaType;

#[Route('/pagina')]
class PaginaController extends BaseController
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

    #[Route('/', name: 'inicio')]
    public function inicio(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta' => 'inicio']);
        $carpeta = $pagina ? $pagina->getCarpeta() : null;

        return $this->renderWithMenu('sitio/index.html.twig', [
            'sitio' => $this->sitio,
            'pagina' => $pagina,
            'carpeta' => $carpeta,
            'menues' => $this->menues,
        ]);

    }

    #[Route('/contacto', name: 'contacto')]
    public function contacto(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta' => 'contacto']);

        return $this->renderWithMenu('contacto/contacto.html.twig', [
            'sitio' => $this->sitio,
            'pagina' => $pagina,
            'menues' => $this->menues,
        ]);
    }

    #[Route('/all', name: 'pagina_index')]
    public function index(PaginaRepository $paginaRepository): Response
    {
        $paginas = $paginaRepository->findAll();
        return $this->renderWithMenu('pagina/index.html.twig', [
            'sitio' => $this->sitio,
            'paginas' => $paginas,
            'menues' => $this->menues,
        ]);
    }

    #[Route('/new', name: 'pagina_new')]
    public function new(Request $request, PaginaRepository $paginaRepository, CarpetaRepository $carpetaRepository): Response
    {
        $pagina = new Pagina();
        $form = $this->createForm(PaginaType::class, $pagina);
        $form->handleRequest($request);
    
        $carpetas = $carpetaRepository->findAll();
    
        if ($form->isSubmitted() && $form->isValid()) {
            $existingPage = $paginaRepository->findOneBy(['ruta' => $pagina->getRuta()]);
            if ($existingPage) {
                $this->addFlash('error', 'La ruta ya existe. Por favor, elija una ruta diferente.');
                return $this->renderWithMenu('pagina/new.html.twig', [
                    'sitio' => $this->sitio,
                    'form' => $form->createView(),
                    'menues' => $this->menues,
                    'pagina' => $pagina,
                ]);
            }
    
            $fotoFile = $form['ruta_imagen_unica']->getData();
            if ($fotoFile) {
                $newFilename = uniqid() . '.' . $fotoFile->guessExtension();
                try {
                    $fotoFile->move(
                        $this->getParameter('app.page_images_directory'),
                        $newFilename
                    );
                    $pagina->setRutaImagenUnica('/uploads/page_images/' . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'No se pudo subir la imagen.');
                }
            }
    
            $this->entityManager->persist($pagina);
            $this->entityManager->flush();
    
            $menu = new Menu();
            $menu->setRuta($pagina->getRuta());
            $menu->setNombre($pagina->getRuta());
            $menu->setVisible(true);
            $menu->setPosicion(0);
    
            $pagina->setMenu($menu);
    
            $this->entityManager->persist($menu);
            $this->entityManager->flush();
    
            if (in_array($pagina->getContenidoTipo(), ['galeria', 'carrusel'])) {
                foreach ($carpetas as $carpeta) {
                    $carpeta->addPagina($pagina);
                    $this->entityManager->persist($carpeta);
                }
                $this->entityManager->flush();
            }
    
            $this->addFlash('success', 'Página creada correctamente.');
            return $this->redirectToRoute('pagina_index');
        }
    
        return $this->renderWithMenu('pagina/new.html.twig', [
            'sitio' => $this->sitio,
            'form' => $form->createView(),
            'menues' => $this->menues,
            'carpetas' => $carpetas,
            'pagina' => $pagina,
        ]);
    }
    


    #[Route('/delete/{ruta}', name: 'pagina_delete')]
    public function delete(string $ruta, PaginaRepository $paginaRepository, MenuRepository $menuRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta' => $ruta]);

        if (!$pagina) {
            throw $this->createNotFoundException('La página no existe');
        }

        if ($pagina->getRuta() === 'inicio') {
            $this->addFlash('error', 'La página "inicio" no puede ser eliminada.');
            return $this->redirectToRoute('pagina_index');
        }

        $this->entityManager->remove($pagina);
        $this->entityManager->flush();

        $menu = $menuRepository->findOneBy(['ruta' => $ruta]);
        if ($menu) {
            $this->entityManager->remove($menu);
            $this->entityManager->flush();
        }

        $this->addFlash('success', 'Página eliminada correctamente.');
        return $this->redirectToRoute('pagina_index');
    }

    #[Route('/edit/{ruta}', name: 'pagina_edit')]
    public function edit(string $ruta, CarpetaRepository $carpetaRepository, PaginaRepository $paginaRepository, MenuRepository $menuRepository, Request $request): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta' => $ruta]);
        if (!$pagina) {
            throw $this->createNotFoundException('La página no existe');
        }
        $carpetas = $carpetaRepository->findAll();

        $rutaAnterior = $pagina->getRuta();
        $form = $this->createForm(PaginaType::class, $pagina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nuevaRuta = $pagina->getRuta();

            if (!preg_match('/^\w+$/', $nuevaRuta)) {
                $this->addFlash('error', 'La ruta debe ser una sola palabra sin espacios ni caracteres especiales.');
                return $this->renderWithMenu('pagina/edit.html.twig', [
                    'sitio' => $this->sitio,
                    'form' => $form->createView(),
                    'menues' => $this->menues,
                    'carpetas' => $carpetas,
                ]);
            }

            $existingPage = $paginaRepository->findOneBy(['ruta' => $nuevaRuta]);
            if ($existingPage && $existingPage->getId() !== $pagina->getId()) {
                $this->addFlash('error', 'La ruta ya existe. Por favor, elija una ruta diferente.');
                return $this->renderWithMenu('pagina/edit.html.twig', [
                    'sitio' => $this->sitio,
                    'form' => $form->createView(),
                    'menues' => $this->menues,
                    'carpetas' => $carpetas,
                ]);
            }

            $fotoFile = $form['ruta_imagen_unica']->getData();
            if ($fotoFile) {
                $newFilename = uniqid() . '.' . $fotoFile->guessExtension();
                try {
                    $fotoFile->move(
                        $this->getParameter('app.page_images_directory'),
                        $newFilename
                    );
                    $pagina->setRutaImagenUnica('/uploads/page_images/' . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'No se pudo subir la imagen.');
                }
            }

            if ($rutaAnterior !== $nuevaRuta) {
                $menu = $menuRepository->findOneBy(['ruta' => $rutaAnterior]);
                if ($menu) {
                    $menu->setRuta($nuevaRuta);
                    $menu->setNombre($nuevaRuta);
                    $menu->setPosicion(0);
                    $this->entityManager->persist($menu);
                } else {
                    $menu = new Menu();
                    $menu->setRuta($nuevaRuta);
                    $menu->setNombre($nuevaRuta);
                    $menu->setVisible(true);
                    $menu->setPosicion(0);
                    $this->entityManager->persist($menu);
                }
            }

            $this->entityManager->persist($pagina);
            $this->entityManager->flush();

            if (in_array($pagina->getContenidoTipo(), ['galeria', 'carrusel'])) {
                foreach ($carpetas as $carpeta) {
                    $carpeta->addPagina($pagina);
                    $this->entityManager->persist($carpeta);
                }
                $this->entityManager->flush();
            }

            $this->addFlash('success', 'Página actualizada correctamente.');
            return $this->redirectToRoute('pagina_show', ['ruta' => $pagina->getRuta()]);
        }

        return $this->renderWithMenu('pagina/edit.html.twig', [
            'pagina' => $pagina,
            'sitio' => $this->sitio,
            'form' => $form->createView(),
            'menues' => $this->menues,
            'carpetas' => $carpetas,
        ]);
    }



    #[Route('/{ruta}', name: 'pagina_show')]
    public function show(string $ruta, PaginaRepository $paginaRepository, MenuRepository $menuRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta' => $ruta]);
        if (!$pagina) {
            throw $this->createNotFoundException('La página no existe');
        }
        

        return $this->renderWithMenu('pagina/show.html.twig', [
            'sitio' => $this->sitio,
            'pagina' => $pagina,
            'menues' => $this->menues,
            
        ]);
    }
}
