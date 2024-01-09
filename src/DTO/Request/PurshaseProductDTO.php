<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Purshase;
use App\Entity\ProductInStorage;

final class PurshaseProductDTO
{
    #[Assert\NotBlank]
    private ProductInStorage $productInStorage;

    private Purshase $purshase;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[Assert\Expression(
        "this.getProductInStorage().getAmount() > value",
        message: 'Заказано {{ value }} больше продуктов чем есть на складе! ',
    )]
    private int $amount;

    /**
     * Get the value of purshase
     *
     * @return Purshase
     */
    public function getPurshase(): Purshase
    {
        return $this->purshase;
    }

    /**
     * Set the value of purshase
     *
     * @param Purshase $purshase
     *
     * @return self
     */
    public function setPurshase(Purshase $purshase): self
    {
        $this->purshase = $purshase;

        return $this;
    }

    /**
     * Get the value of productInStorage
     *
     * @return ProductInStorage
     */
    public function getProductInStorage(): ProductInStorage
    {
        return $this->productInStorage;
    }

    /**
     * Set the value of productInStorage
     *
     * @param ProductInStorage $productInStorage
     *
     * @return self
     */
    public function setProductInStorage(ProductInStorage $productInStorage): self
    {
        $this->productInStorage = $productInStorage;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}