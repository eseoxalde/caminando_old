<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\SitioRepository;
use App\Repository\MenuRepository;

#[Route('/menu')]
class MenuController extends BaseController
{
    private $sitio;
    private $menues;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SitioRepository $sitioRepository, MenuRepository $menuRepository)
    {
        parent::__construct($menuRepository);
        $this->entityManager = $entityManager;
        $this->sitio = $sitioRepository->findOneBy([], ['id' => 'DESC']);
        $this->menues = $menuRepository->findVisibleMenus();
    }

    #[Route('/', name: 'menu_index')]
    public function index(MenuRepository $menuRepository): Response
    {
        $menus = $menuRepository->findAll();
    
        $menuTree = $this->buildMenuTree($menus);
    
        return $this->renderWithMenu('menu/index.html.twig', [
            'menuTree' => $menuTree,
            'sitio' => $this->sitio,
            'menues' => $this->menues,
        ]);
    }

    #[Route('/{id}/edit', name: 'menu_edit')]
    public function edit(Menu $menu, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('menu_index');
        }


        return $this->renderWithMenu('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
            'sitio'=> $this->sitio,
            'menues' => $this->menues,
        ]);
    }

    private function buildMenuTree(array $menus, ?Menu $parent = null): array
    {
        $branch = [];
        foreach ($menus as $menu) {
            if ($menu->getParent() === $parent) {
                $children = $menu->getChildrenArray($menu); // Filtrar hijos solo para este menú
                $menu->setChildren($this->buildMenuTree($menus, $menu));
                $branch[] = $menu;
            }
        }
        return $branch;
    }
    
    
}
