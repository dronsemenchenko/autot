<?php

declare(strict_types=1);

namespace App\DTO\Request\Transformer;

use App\DTO\Request\ClientDTO;
use App\Entity\Client;

class ClientRequestDtoTransformer extends AbstractRequestDtoTransformer
{
    public function transformToObject(object $clientDTO): Client
    {
        $client = new Client();
        $client->setEmail($clientDTO->getEmail());
        $client->setPhone($clientDTO->getPhone());
        return $client;
    }
}