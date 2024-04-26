<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use src\Repository\SitioPaginaRepository;

use App\Entity\Pagina;
use App\Repository\SitioRepository;
use App\Repository\PaginaRepository;
use Doctrine\ORM\EntityManagerInterface;

class SitioController extends AbstractController
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

    #[Route('/', name: 'inicio')]
    public function index(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta'=>'inicio']);
       
        return $this->render('sitio/index.html.twig', [
            'controller_name' => 'SitioController',
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>$pagina->getTitulo(),
            'subtitulo'=>$pagina->getsubTitulo(),
            'texto'=>$pagina->getTexto(),
        ]);
    }

    #[Route('/documental', name: 'documental')]
    public function documental(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta'=>'documental']);
        return $this->render('sitio/documental.html.twig', [
            'controller_name' => 'SitioController',
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>$pagina->getTitulo(),
            'subtitulo'=>$pagina->getsubTitulo(),
            'texto'=>$pagina->getTexto(),
        ]);
    }

    #[Route('/actividades', name: 'actividades')]
    public function actividades(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta'=>'actividades']);

        return $this->render('sitio/actividades.html.twig', [
            'controller_name' => 'SitioController',
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>$pagina->getTitulo(),
            'subtitulo'=>$pagina->getsubTitulo(),
            'texto'=>$pagina->getTexto(),
        ]);
    }

    #[Route('/contacto', name: 'contacto')]
    public function contacto(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta'=>'contacto']);

        return $this->render('sitio/contacto.html.twig', [
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>$pagina->getTitulo(),
            'subtitulo'=>$pagina->getsubTitulo(),
            'texto'=>$pagina->getTexto(),
            'ruta_imagen_tipo1'=>$pagina->getRutaImagenTipo1(),
            'imagen_tipo1'=>$pagina->isImagenTipo1(),
        ]);
    }

    #[Route('/cuentos', name: 'cuentos')]
    public function cuentos(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta'=>'cuentos']);

        return $this->render('sitio/cuentos.html.twig', [
            'controller_name' => 'SitioController',
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>$pagina->getTitulo(),
            'subtitulo'=>$pagina->getsubTitulo(),
            'texto'=>$pagina->getTexto(),
        ]);
    }

    #[Route('/fichas', name: 'fichas')]
    public function fichas(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta'=>'fichas']);

        return $this->render('sitio/fichas.html.twig', [
            'controller_name' => 'SitioController',
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>$pagina->getTitulo(),
            'subtitulo'=>$pagina->getsubTitulo(),
            'texto'=>$pagina->getTexto(),
        ]);
    }

    #[Route('/foro', name: 'foro')]
    public function foro(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta'=>'foro']);

        return $this->render('sitio/foro.html.twig', [
            'controller_name' => 'SitioController',
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>$pagina->getTitulo(),
            'subtitulo'=>$pagina->getsubTitulo(),
            'texto'=>$pagina->getTexto(),
        ]);
    }

    #[Route('/libro', name: 'libro')]
    public function libro(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta'=>'libro']);

        return $this->render('sitio/libro.html.twig', [
            'controller_name' => 'SitioController',
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>$pagina->getTitulo(),
            'subtitulo'=>$pagina->getsubTitulo(),
            'texto'=>$pagina->getTexto(),
        ]);
    }

    #[Route('/reconstrucciones', name: 'reconstrucciones')]
    public function reconstrucciones(PaginaRepository $paginaRepository): Response
    {
        $pagina = $paginaRepository->findOneBy(['ruta'=>'reconstrucciones']);

        return $this->render('sitio/actividades.html.twig', [
            'controller_name' => 'SitioController',
            'title'=> $this->title,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'=>$this->twitter,
            'titulo'=>$pagina->getTitulo(),
            'subtitulo'=>$pagina->getsubTitulo(),
            'texto'=>$pagina->getTexto(),
        ]);
    }

  
}
