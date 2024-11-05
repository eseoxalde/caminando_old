<?php

namespace App\Controller;

use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use App\Repository\SitioRepository;
use App\Repository\MenuRepository;
use App\Form\UserType;
use App\Form\MenuType;


#[Route('/usuario')]
class UserController extends BaseController
{
    private $sitio;
    private $entityManager;
    private $userRepository;
    private $menues;

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository, UserRepository $userRepository, MenuRepository $menuRepository)
    {
        parent::__construct($menuRepository);
        $this->entityManager = $entityManager;
        $this->sitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->userRepository = $userRepository;
        $this->menues = $menuRepository->findVisibleMenus();
    }

    #[Route('/all', name: 'usuario_index')]
    public function index(): Response
    {
        $usuarios = $this->userRepository->findAll();
        return $this->renderWithMenu('user/index.html.twig', [
            'sitio'=> $this->sitio,
            'usuarios' => $usuarios,
            'menues' =>  $this->menues,
        ]);
    }

    #[Route('/{id}/edit', name: 'usuario_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager,): Response
    {
        $form = $this->createForm(UserType::class, $user);
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
            $entityManager->flush();
            $this->addFlash('success', 'Usuario actualizado correctamente.');

            return $this->redirectToRoute('usuario_index');
        }

        return $this->renderWithMenu('user/edit.html.twig', [
            'sitio' => $this->sitio,
            'user' => $user,
            'form' => $form->createView(),
            'menues' =>  $this->menues,
        ]);
    }

    #[Route('/{id}/delete', name: 'usuario_delete')]
    public function delete(User $user): Response
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $this->addFlash('success', 'Usuario eliminado correctamente.');

        return $this->redirectToRoute('usuario_index');
    }

}
