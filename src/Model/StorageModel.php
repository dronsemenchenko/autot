<?php

namespace App\Model;

use App\Service\Serializer\DTOSerializer;
use App\Repository\StorageRepository;

class StorageModel {

    public function __construct(
        private StorageRepository $storageRepository
    ) {
    }

    public function getList(){
        $serializer = new DTOSerializer();
        return $serializer->serialize(
            $this->storageRepository->findAll(), 'json'
        );
    }
    
}