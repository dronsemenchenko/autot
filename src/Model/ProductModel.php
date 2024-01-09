<?php

namespace App\Model;

use Exception;
use App\Service\Serializer\DTOSerializer;
use App\Repository\ProductRepository;
use App\Repository\ProductInStorageRepository;
use App\Repository\CityRepository;
use App\Repository\StorageRepository;

class ProductModel {

    public function __construct(
        private ProductRepository $productRepository,
        private ProductInStorageRepository $productInStorageRepository,
        private CityRepository $cityRepository,
        private StorageRepository $storageRepository,
        private DTOSerializer $serializer     
    ) {
    }

    // список доступных товаров 
    // остатки на всех складах
    public function getAvailableList(){
        return $this->serializer->serialize(
            $this->productRepository->getAvailableList(), 'json'
        );
    }

    // список доступных товаров 
    // остатки на всех складах в Городе
    public function getAvailableListByCity(int $city_id){
        $city = $this->cityRepository->find($city_id);
        if(!$city){
            throw new Exception('Город с id ='.$city_id.' не обнаружен');
        }
        return $this->serializer->serialize(
            $this->productRepository->getAvailableListByCity($city), 'json'
        );
    }

    // список доступных товаров 
    // остатки на конкретном складе
    public function getAvailableListByStorage(int $storage_id){
        $storage = $this->storageRepository->find($storage_id);
        if(!$storage){
            throw new Exception('Склад с id ='.$storage_id.' не обнаружен');
        }
        return $this->serializer->serialize(
            $this->productRepository->getAvailableListByStorage($storage), 'json'
        );
    }
    
}