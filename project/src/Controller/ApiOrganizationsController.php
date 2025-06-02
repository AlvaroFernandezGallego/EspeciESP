<?php

namespace App\Controller;

use App\Repository\OrganizationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ApiOrganizationsController extends AbstractController
{
    #[Route('/organizations/by-region/{regionName}', name: 'api_organizations_by_region', methods: ['GET'])]
    public function byRegion(string $regionName, OrganizationsRepository $repository): JsonResponse
    {
        // Obtener organizaciones por región
        $organizations = $repository->findByRegionName($regionName);

        // Si no hay organizaciones, devolver un arreglo vacío
        if (empty($organizations)) {
            return new JsonResponse([]);
        }

        $data = [];

        // Recorrer las organizaciones y estructurar los datos
        foreach ($organizations as $org) {
            $socialMediaLinks = [];
            $socialMedia = $org->getSocialMedia();

            // Separar las redes sociales por coma y espacio
            if ($socialMedia) {
                $socialMediaLinks = array_map('trim', explode(',', $socialMedia));
            }

            $data[] = [
                'name' => $org->getName(),
                'address' => $org->getAddress(),
                'email' => $org->getEmail(),
                'phoneNumber' => $org->getPhoneNumber(),
                'websiteUrl' => $org->getWebsiteUrl(),
                'socialMedia' => $socialMediaLinks, // Pasar las redes sociales como arreglo
            ];
        }

        // Responder con los datos en formato JSON
        return new JsonResponse($data);
    }
}
