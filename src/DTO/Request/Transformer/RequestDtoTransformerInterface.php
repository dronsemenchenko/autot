<?php

namespace App\DTO\Request\Transformer;

interface RequestDtoTransformerInterface
{
    public function transformToObject(object  $dto): object;
    public function transformToObjects(iterable $objects): iterable;
}