<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    protected function renderWithMenu(string $view, array $parameters = [], Response $response = null): Response
    {
        $parameters['menues'] = $this->menuRepository->findVisibleMenus();
        return $this->render($view, $parameters, $response);
    }
}
