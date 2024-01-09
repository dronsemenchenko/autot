<?php

declare(strict_types=1);

namespace App\DTO\Request\Transformer;

use App\DTO\Request\DeliveryAddressDTO;
use App\Entity\DeliveryAddress;

class DeliveryAddressesRequestDtoTransformer extends AbstractRequestDtoTransformer
{
    public function transformToObject(object $deliveryAddressDTO): DeliveryAddress
    {
        $deliveryAddress = new DeliveryAddress();
        $deliveryAddress->setCity($deliveryAddressDTO->getCity());
        $deliveryAddress->setClient($deliveryAddressDTO->getClient());
        $deliveryAddress->setStreet($deliveryAddressDTO->getStreet());
        $deliveryAddress->setHouseNum($deliveryAddressDTO->getHouseNum());
        $deliveryAddress->setApartmentNum($deliveryAddressDTO->getApartmentNum());
        return $deliveryAddress;
    }
}