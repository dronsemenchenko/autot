<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

use App\Model\PurshaseStatusModel;

#[OA\Tag(name: 'PurshaseStatus')]
#[Route("/api", name: "api_")]
class PurshaseStatusController extends AbstractController
{
    public function __construct(
        private PurshaseStatusModel $purshaseStatusModel
    ) {
    }

    #[OA\Response(
        response: 200,
        description: 'Show list purshase status',
    )]
    #[Route('/purshase/status/list', name: 'app_purshase_status_list', methods: ["GET"])]
    public function list(): JsonResponse
    {
        return new JsonResponse(
            data: $this->purshaseStatusModel->getList(), 
            status: Response::HTTP_OK, 
            json: true
        );        
    }
}
