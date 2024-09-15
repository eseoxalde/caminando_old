<?php

namespace App\Controller;

use App\Entity\Carpeta;
use App\Entity\Imagen;
use App\Entity\Pagina;
use App\Form\CarpetaType;
use App\Form\ImagenType;
use App\Repository\CarpetaRepository;
use App\Repository\ImagenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SitioRepository;
use App\Repository\MenuRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;


#[Route('/carpeta')]
class CarpetaController extends BaseController
{
    private $sitio;
    private $menues;
    private $entityManager;
    private $imagenRepository;
    private $directoriesPath;

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository, MenuRepository $menuRepository, ImagenRepository $imagenRepository, ParameterBagInterface $params)
    {
        parent::__construct($menuRepository);
        $this->entityManager = $entityManager;
        $this->sitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->menues = $menuRepository->findVisibleMenus();
        $this->imagenRepository = $imagenRepository;
        $this->directoriesPath = $params->get('directories_path');
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'carpeta_index', methods: ['GET'])]
    public function index(CarpetaRepository $carpetaRepository): Response
    {
        $carpetas = $carpetaRepository->findAll();

        return $this->renderWithMenu('carpeta/index.html.twig', [
            'carpetas' => $carpetas,
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'carpeta_new', methods: ['GET', 'POST'])]
    public function new(Request $request,CarpetaRepository $carpetaRepository): Response
    {
        $carpetas = $carpetaRepository->findAll();
        $carpeta = new Carpeta();
        $form = $this->createForm(CarpetaType::class, $carpeta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filesystem = new Filesystem();
            $nuevaCarpetaPath = $this->directoriesPath.'/'.$carpeta->getNombre();

            if (!$filesystem->exists($nuevaCarpetaPath)) {
                $filesystem->mkdir($nuevaCarpetaPath);
            }

            $this->entityManager->persist($carpeta);
            $this->entityManager->flush();

            return $this->redirectToRoute('carpeta_index');
        }

        return $this->renderWithMenu('carpeta/new.html.twig', [
            'carpeta' => $carpeta,
            'carpetas' => $carpetas,
            'form' => $form->createView(),
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }


    #[Route('/{id}', name: 'carpeta_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Carpeta $carpeta): Response
    {
        $form = $this->createForm(ImagenType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagenFile = $form->get('path')->getData();

            if ($imagenFile) {
                $newFilename = uniqid().'.'.$imagenFile->guessExtension();
                $imagesDir = $this->directoriesPath.'/'.$carpeta->getNombre();

                try {
                    $imagenFile->move($imagesDir, $newFilename);
                } catch (FileException $e) {
                    
                    $this->addFlash('error', 'No se pudo cargar la imagen.');
                    return $this->redirectToRoute('carpeta_show', ['id' => $carpeta->getId()]);
                }

                $imagen = new Imagen();
                $imagen->setPath($carpeta->getNombre().'/'.$newFilename);
                $imagen->setAltText($form->get('altText')->getData());
                $carpeta->addImagen($imagen);

                $this->entityManager->persist($imagen);
                $this->entityManager->flush();
            }

            return $this->redirectToRoute('carpeta_show', ['id' => $carpeta->getId()]);
        }

        return $this->renderWithMenu('carpeta/show.html.twig', [
            'carpeta' => $carpeta,
            'form' => $form->createView(),
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'carpeta_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Carpeta $carpeta): Response
    {
        $form = $this->createForm(CarpetaType::class, $carpeta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $originalName = $carpeta->getNombre();
            $newName = $form->get('nombre')->getData();
            echo "carpeta.\n $originalName";

            if ($originalName !== $newName) {
                $originalPath = $this->directoriesPath . '/' . $originalName;
                $newPath = $this->directoriesPath . '/' . $newName;

                if (is_dir($originalPath)) {
                    try {

                        rename($originalPath, $newPath);
                    } catch (\Exception $e) {
                        $this->addFlash('error', 'Error al renombrar la carpeta en el sistema de archivos: ' . $e->getMessage());
                        return $this->redirectToRoute('carpeta_edit', ['id' => $carpeta->getId()]);
                    }
                } else {
                    $this->addFlash('error', 'La carpeta original no existe en el sistema de archivos.');
                    return $this->redirectToRoute('carpeta_edit', ['id' => $carpeta->getId()]);
                }
            }

            $this->entityManager->flush();

            $this->addFlash('success', 'Carpeta editada correctamente.');
            return $this->redirectToRoute('carpeta_index');
        }
    
        return $this->renderWithMenu('carpeta/edit.html.twig', [
            'carpeta' => $carpeta,
            'form' => $form->createView(),
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/delete/{id}', name: 'carpeta_delete', methods: ['POST'])]
    public function delete(Request $request, Carpeta $carpeta, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $csrfToken = $request->request->get('_token');
        if (!$csrfTokenManager->isTokenValid(new CsrfToken('delete' . $carpeta->getId(), $csrfToken))) {
            throw $this->createAccessDeniedException('Token CSRF no válido');
        }
    
        $carpetaPath = $this->directoriesPath . '/' . $carpeta->getNombre();
    
        if (is_dir($carpetaPath)) {
            $this->deleteDirectory($carpetaPath);
        }
    
        foreach ($carpeta->getPaginas() as $pagina) {
            $pagina->setContenidoTipo('vacio');
            $pagina->setCarpeta(null);  
            $this->entityManager->persist($pagina);
        }
        $this->entityManager->remove($carpeta);
        $this->entityManager->flush();
    
        $this->addFlash('success', 'Carpeta eliminada correctamente.');
    
        return $this->redirectToRoute('carpeta_index');
    }
    


    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->deleteDirectory("$dir/$file") : unlink("$dir/$file");
        }

        rmdir($dir);
    }
}
