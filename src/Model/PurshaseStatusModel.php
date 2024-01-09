<?php

namespace App\Model;

use App\Service\Serializer\DTOSerializer;
use App\Repository\PurshaseStatusRepository;

class PurshaseStatusModel {

    public function __construct(
        private PurshaseStatusRepository $purshaseStatusRepository
    ) {
    }

    public function getList(){
        $serializer = new DTOSerializer();
        return $serializer->serialize(
            $this->purshaseStatusRepository->findAll(), 'json'
        );
    }
    
}