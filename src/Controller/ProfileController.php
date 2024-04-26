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
use Doctrine\ORM\EntityManagerInterface;

class ProfileController extends AbstractController
{
    private $entityManager;
    private $elSitio;
    private $facebook;
    private $instagram;
    private $twiter;
    private $mailppal;
    private $title;

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository)
    {
        $this->entityManager = $entityManager;
        $this->elSitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->title = $this->elSitio->getNombreSitio() ?: 'Caminando sobre Gliptodontes y Tigres Diente de Sable ';
        $this->facebook = $this->elSitio->getFacebook() ?? 'https://www.facebook.com/';
        $this->instagram = $this->elSitio->getInstagram() ?? 'https://www.instagram.com/';
        $this->twitter = $this->elSitio->getTwiter() ?? 'https://twitter.com/';
    }

    #[Route('/perfil', name: 'perfil')]
    public function perfil(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta'=>'perfil']);

        return $this->render('perfil/perfil.html.twig', [
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>$pagina->getTitulo(),
            'subtitulo'=>$pagina->getsubTitulo(),
            'texto'=>$pagina->getTexto(),
        ]);
    }
    
    #[Route('/perfil/editar', name: 'editarPerfil')]
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

            return $this->redirectToRoute('perfil'); // Regresar a la página de perfil
        }

        return $this->render('perfil/perfil_editar.html.twig', [
            'form' => $form->createView(),
            'title' => $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter' => $this->twiter,
            'titulo' => 'Editar perfil',
        ]);
    }
}
