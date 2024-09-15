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
use App\Entity\Imagen;


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
    public function delete(Request $request, Imagen $imagen): Response
    {
        if ($this->isCsrfTokenValid('delete' . $imagen->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($imagen);
            $this->entityManager->flush();
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

    #[Route('/{id}/edit', name: 'imagen_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Imagen $imagen): Response
    {
        $form = $this->createFormBuilder($imagen)
            ->add('altText', null, [
                'label' => 'Texto Alternativo',
                'attr' => ['class' => 'form-control']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('carpeta_show', ['id' => $imagen->getCarpeta()->getId()]);
        }

        return $this->render('imagen/edit.html.twig', [
            'form' => $form->createView(),
            'imagen' => $imagen,
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }
}
