<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panel')]
class PanelController extends AbstractController
{
    #[Route('', name: 'app_panel')]
    public function index(): Response
    {
        return $this->render('panel/index.html.twig');
    }
} 