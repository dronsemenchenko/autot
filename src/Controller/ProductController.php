<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

use App\Model\ProductModel;
use App\Model\ProductInStorageModel;

#[OA\Tag(name: 'Product')]
#[Route("/api", name: "api_")]
class ProductController extends AbstractController
{
    public function __construct(
        private ProductInStorageModel $productInStorageModel,
        private ProductModel $productModel
    ) {
    }

    #[OA\Response(
        response: 200,
        description: 'Show list all Products on all Storage',
    )]
    #[Route('/product/on_storage', name: 'app_product_on_storage', methods: ["GET"])]
    public function listOnStorage(): JsonResponse
    {
        return new JsonResponse(
            data: $this->productInStorageModel->getAvailableList(), 
            status: Response::HTTP_OK, 
            json: true
        );        
    }

    #[OA\Response(
        response: 200,
        description: 'Show list all Products with balances in all warehouses',
    )]
    #[Route('/product/list', name: 'app_product_list', methods: ["GET"])]
    public function list(): JsonResponse
    {
        return new JsonResponse(
            data: $this->productModel->getAvailableList(), 
            status: Response::HTTP_OK, 
            json: true
        );        
    }

    #[OA\Response(
        response: 200,
        description: 'Show list all Products with balances in warehouses in City',
    )]
    #[OA\Parameter(
        name: 'city_id',
        in: 'path',
        description: 'City ID',
        schema: new OA\Schema(type: 'integer')
    )]
    #[Route('/product/list/city/{city_id}', name: 'app_product_list_by_city', methods: ["GET"])]
    public function getAvailableListByCity(int $city_id): JsonResponse
    {
        return new JsonResponse(
            data: $this->productModel->getAvailableListByCity($city_id), 
            status: Response::HTTP_OK, 
            json: true
        );        
    }

    #[OA\Response(
        response: 200,
        description: 'Show list all Products with balances in warehouses',
    )]
    #[OA\Parameter(
        name: 'storage_id',
        in: 'path',
        description: 'Storage ID',
        schema: new OA\Schema(type: 'integer')
    )]
    #[Route('/product/list/storage/{storage_id}', name: 'app_product_list_by_storage', methods: ["GET"])]
    public function getAvailableListByStorage(int $storage_id): JsonResponse
    {
        return new JsonResponse(
            data: $this->productModel->getAvailableListByStorage($storage_id), 
            status: Response::HTTP_OK, 
            json: true
        );        
    }
    
}
