<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use src\Repository\SitioPaginaRepository;

use App\Repository\SitioRepository;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
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

    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig',
         [
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>'Ingresar',
         'last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
