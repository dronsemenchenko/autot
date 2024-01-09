<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

use App\Model\CityModel;

#[OA\Tag(name: 'City')]
#[Route("/api", name: "api_")]
class CityController extends AbstractController
{
    public function __construct(
        private CityModel $cityModel
    ) {
    }

    #[OA\Response(
        response: 200,
        description: 'Show list City',
    )]
    #[Route('/city', name: 'app_city', methods: ["GET"])]
    public function list(CityModel $city): JsonResponse
    {
        
        return new JsonResponse(
            data: $this->cityModel->getList(),
            status: Response::HTTP_OK, 
            json: true
        );        
    }
}
