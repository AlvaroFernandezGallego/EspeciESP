<?php

namespace App\Controller\Admin;

use App\Repository\SpeciesRepository;
use App\Repository\OrganizationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(SpeciesRepository $speciesRepository, OrganizationRepository $organizationRepository): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'species_count' => $speciesRepository->count([]),
            'organizations_count' => $organizationRepository->count([]),
        ]);
    }
} 