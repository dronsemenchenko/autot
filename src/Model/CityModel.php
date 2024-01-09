<?php

namespace App\Model;

use App\Service\Serializer\DTOSerializer;
use App\Repository\CityRepository;

class CityModel {

    public function __construct(
        private CityRepository $cityRepository
    ) {
    }

    public function getList(){
        $serializer = new DTOSerializer();
        return $serializer->serialize(
            $this->cityRepository->findAll(), 'json'
        );
    }
    
}