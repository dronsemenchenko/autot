<?php

declare(strict_types=1);

namespace App\DTO\Request\Transformer;

abstract class AbstractRequestDtoTransformer implements RequestDtoTransformerInterface
{
    public function transformToObjects(iterable $objects): iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            $dto[] = $this->transformToObject($object);
        }

        return $dto;
    }

}