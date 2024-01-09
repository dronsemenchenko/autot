<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Attributes as OA;

use App\Model\PurshaseModel;

#[OA\Tag(name: 'Purshase')]
#[Route("/api", name: "api_")]
class PurshaseController extends AbstractController
{
    public function __construct(
        private PurshaseModel $purshaseModel
    ) {
    }

    #[Route('/purshase', name: 'app_purshase', methods: ["POST"])]
    #[OA\Response(
        response: 200,
        description: 'Purshase',
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: "object",
            example: '{
                "client":{
                    "email":"test@test.ru",
                    "phone":"89271111111",
                    "deliveryAddress":{
                        "city": 27,
                        "street": "Вернадского",
                        "houseNum": 11,
                        "apartmentNum": 11
                    }
                },
                "purshaseProducts": [
                    {
                        "id": 3,
                        "amount": 10
                    },
                    {
                        "id": 4,
                        "amount": 20
                    },
                    {
                        "id": 6,
                        "amount": 10
                    }
                ]
            }'
        )
    )]
    public function create(Request $request): JsonResponse
    {
        $result = $this->purshaseModel->create($request);

        $message = ['status' => 'success', 'message' => 'CREATED', 'purshase_id' => $result->getId()];
        $message = json_encode($message);
        return new JsonResponse(
            data: $message,
            status: Response::HTTP_CREATED,
            json: true
        );
    }
}
