<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use App\Form\UserProfileType;
use App\Entity\Pagina;
use App\Repository\SitioRepository;
use App\Repository\PaginaRepository;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/perfil')]
class ProfileController extends BaseController
{
    private $entityManager;
    private $sitio;
    private $menues;

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository, MenuRepository $menuRepository)
    {
        parent::__construct($menuRepository);
        $this->entityManager = $entityManager;
        $this->sitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->menues = $menuRepository->findVisibleMenus();    }

    #[Route('/', name: 'perfil')]
    public function perfil(PaginaRepository $paginaRepository): Response
    {
        return $this->renderWithMenu('perfil/index.html.twig', [
            'sitio'=> $this->sitio,
            'menues' => $this->menues,
        ]);
    }
    
    #[Route('/edit', name: 'profile_edit')]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        PaginaRepository $paginaRepository
    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fotoFile = $form['foto']->getData();
            if ($fotoFile) {
                $newFilename = uniqid() . '.' . $fotoFile->guessExtension();
                try {
                    $fotoFile->move(
                        $this->getParameter('app.user_profile_pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $form['foto']->addError(new FormError("No se pudo subir la imagen."));
                }
                $user->setFoto('/uploads/profile_pictures/' . $newFilename);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Perfil actualizado con éxito.');
            return $this->redirectToRoute('perfil');
        }

        return $this->renderWithMenu('perfil/edit.html.twig', [
            'form' => $form->createView(),
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }
}
