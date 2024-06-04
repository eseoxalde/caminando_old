<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Form\ContactType;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SitioRepository;
use App\Repository\PaginaRepository;
use App\Repository\MenuRepository;


class ContactoController extends BaseController
{
    private $entityManager;
    private $sitio;
    private $menuRepository;

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository, MenuRepository $menuRepository)
    {
        parent::__construct($menuRepository);
        $this->entityManager = $entityManager;
        $this->sitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->menuRepository = $menuRepository;
    }

    #[Route('/contacto', name: 'contacto')]
    public function contact(PaginaRepository $paginaRepository, Request $request, MenuRepository $menuRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta'=>'contacto']);
        $this->menues = $menuRepository->findVisibleMenus();
        
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($contact);
            $this->entityManager->flush();
            $this->addFlash('success', 'Gracias por tu mensaje. Te contactaremos pronto.');
            return $this->redirectToRoute('contacto');
        }

        return $this->renderWithMenu('contacto/contacto.html.twig', [
                'sitio' => $this->sitio,
                'pagina'=>$pagina,
                'contact_form' => $form->createView(),
                'menues' => $menues,
            ]);
    }
}
