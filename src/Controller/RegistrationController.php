<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

use src\Repository\SitioPaginaRepository;

use App\Repository\SitioRepository;

class RegistrationController extends AbstractController
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
    
    #[Route('/registrarse', name: 'registrarse')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(['ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $security->login($user, UserAuthenticator::class, 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>'Registrarse',
        ]);
    }
}
