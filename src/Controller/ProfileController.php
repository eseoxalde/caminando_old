<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use App\Form\UserProfileType;
use App\Entity\Pagina;
use App\Entity\Sesion;
use App\Entity\ActividadAcceso;
use App\Entity\Post;
use App\Repository\SitioRepository;
use App\Repository\PaginaRepository;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\FavoritePost;
use App\Entity\Comentario;


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
        $this->menues = $menuRepository->findVisibleMenus();
    }

    #[Route('/', name: 'perfil')]
    public function perfil(EntityManagerInterface $em, PaginaRepository $paginaRepository): Response
    {
        $user = $this->getUser();
    
        $sesiones = $em->getRepository(Sesion::class)->findBy(['user' => $user]);
        $actividadAccesos = $em->getRepository(ActividadAcceso::class)->findBy(['user' => $user]);
        $ultimoAcceso = $user->getUltimoAcceso();
    
        $ultimoMensaje = $em->getRepository(Post::class)->findOneBy(['author' => $user], ['createdAt' => 'DESC']);
    
        $postFavoritos = $em->getRepository(FavoritePost::class)->findBy(['user' => $user]);
        $posts = [];
        foreach ($postFavoritos as $favoritePost) {
            $posts[] = $favoritePost->getPost();
        }
    
        $ultimosPosts = $em->getRepository(Post::class)->findBy(
            ['author' => $user], 
            ['createdAt' => 'DESC'],
            5
        );
    
        $ultimosComentarios = $em->getRepository(Comentario::class)->findBy(
            ['author' => $user], 
            ['createdAt' => 'DESC'],
            5
        );
    
        return $this->renderWithMenu('perfil/index.html.twig', [
            'sitio' => $this->sitio,
            'menues' => $this->menues,
            'sesiones' => $sesiones,
            'actividadAccesos' => $actividadAccesos,
            'ultimoAcceso' => $ultimoAcceso,
            'ultimoMensaje' => $ultimoMensaje,
            'posts' => $posts,
            'ultimosPosts' => $ultimosPosts,
            'ultimosComentarios' => $ultimosComentarios,
        ]);
    }
    


    #[Route('/{id}', name: 'user_profile')]
    public function show(User $user): Response
    {
        $sesiones = $this->entityManager->getRepository(Sesion::class)->findBy(['user' => $user]);
        $actividadAccesos = $this->entityManager->getRepository(ActividadAcceso::class)->findBy(['user' => $user]);
        $ultimoAcceso = $user->getUltimoAcceso();
        $ultimoMensaje = $this->entityManager->getRepository(Post::class)->findOneBy(['author' => $user], ['createdAt' => 'DESC']);

        return $this->renderWithMenu('perfil/show.html.twig', [
            'user' => $user,
            'sitio' => $this->sitio,
            'menues' => $this->menues,
            'sesiones' => $sesiones,
            'actividadAccesos' => $actividadAccesos,
            'ultimoAcceso' => $ultimoAcceso,
            'ultimoMensaje' => $ultimoMensaje,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'profile_edit')]
    public function edit(
        Request $request,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('No se ha autenticado ningún usuario.');
        }

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
            $this->entityManager->persist($user);
            $this->entityManager->flush();
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
