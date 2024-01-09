<?php

namespace App\Model;

use Exception;
use App\Service\Serializer\DTOSerializer;
use App\Repository\ProductInStorageRepository;
use App\Repository\CityRepository;
use App\Repository\StorageRepository;

class ProductInStorageModel {

    public function __construct(
        private ProductInStorageRepository $productInStorageRepository,
        private DTOSerializer $serializer
    ) {
    }

    // список доступных товаров на всех складах
    public function getAvailableList(){
        return $this->serializer->serialize(
            $this->productInStorageRepository->getAvailableList(), 'json'
        );
    }
    
}