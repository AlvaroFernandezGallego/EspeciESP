<?php
namespace App\Controller;

use App\Repository\SpeciesRepository;
use App\Repository\CategoriesRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class ApiSpeciesController extends AbstractController
{
    #[Route('/species', name: 'species_list', methods: ['GET'])]
    public function list(SpeciesRepository $speciesRepository, Request $request): JsonResponse
    {
        $search = $request->query->get('search', '');
        $categories = $request->query->get('categories', '');
        $statuses = $request->query->get('statuses', '');

        $categoryIds = $categories ? explode(',', $categories) : [];
        $statusIds = $statuses ? explode(',', $statuses) : [];

        $speciesList = $speciesRepository->findByFilters($search, $categoryIds, $statusIds);

        $data = [];

        foreach ($speciesList as $species) 
        {
            $data[] = [
                'id' => $species->getId(),
                'scientificName' => $species->getScientificName(),
                'commonName' => $species->getCommonName(),
                'image' => $species->getImage(),
                'category' => $species->getCategory() ? [
                    'id' => $species->getCategory()->getId(),
                    'name' => $species->getCategory()->getName(),
                ] : null,
                'status' => $species->getStatus() ? [
                    'id' => $species->getStatus()->getId(),
                    'name' => $species->getStatus()->getName(),
                ] : null,
            ];
        }
        return $this->json($data);
    }

    #[Route('/categories', name: 'categories_list', methods: ['GET'])]
    public function categories(CategoriesRepository $categoriesRepository): JsonResponse
    {
        $categories = $categoriesRepository->findAll();
        $data = [];

        foreach ($categories as $category) 
        {
            $data[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
            ];
        }
        return $this->json($data);
    }

    #[Route('/statuses', name: 'statuses_list', methods: ['GET'])]
    public function statuses(StatusRepository $statusRepository): JsonResponse
    {
        $statuses = $statusRepository->findAll();
        $data = [];

        foreach ($statuses as $status) 
        {
            $data[] = [
                'id' => $status->getId(),
                'name' => $status->getName(),
            ];
        }
        return $this->json($data);
    }
}