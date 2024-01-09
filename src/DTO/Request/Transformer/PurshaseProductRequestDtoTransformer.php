<?php

declare(strict_types=1);

namespace App\DTO\Request\Transformer;

use App\Entity\PurshaseProduct;

class PurshaseProductRequestDtoTransformer extends AbstractRequestDtoTransformer
{

    public function transformToObject(object $purshaseProductDTO): PurshaseProduct
    {
        $purshaseProduct = new PurshaseProduct();
        $purshaseProduct->setPurshase($purshaseProductDTO->getPurshase());
        $purshaseProduct->setProductInStorage($purshaseProductDTO->getProductInStorage());
        $purshaseProduct->setAmount($purshaseProductDTO->getAmount());        
        return $purshaseProduct;
    }
}