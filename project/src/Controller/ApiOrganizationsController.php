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
        $organizations = $repository->findByRegionName($regionName);

        if (empty($organizations)) 
        {
            return new JsonResponse([]);
        }
        $data = [];

        foreach ($organizations as $org) 
        {
            $data[] = [
                'name' => $org->getName(),
                'address' => $org->getAddress(),
                'email' => $org->getEmail(),
                'phoneNumber' => $org->getPhoneNumber(),
                'websiteUrl' => $org->getWebsiteUrl(),
            ];
        }
        return new JsonResponse($data);
    }
}