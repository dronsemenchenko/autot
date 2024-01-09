<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

use App\Model\StorageModel;

#[OA\Tag(name: 'Storage')]
#[Route("/api", name: "api_")]
class StorageController extends AbstractController
{
    public function __construct(
        private StorageModel $storageModel
    ) {
    }

    #[OA\Response(
        response: 200,
        description: 'Show list Storage',
    )]
    #[Route('/storage/list', name: 'app_storage', methods: ["GET"])]
    public function list(): JsonResponse
    {
        return new JsonResponse(
            data: $this->storageModel->getList(), 
            status: Response::HTTP_OK, 
            json: true
        );        
    }
}
