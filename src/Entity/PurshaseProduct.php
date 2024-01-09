<?php

namespace App\Entity;

use App\Repository\PurshaseProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurshaseProductRepository::class)]
class PurshaseProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'purshaseProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private Purshase $purshase;

    #[ORM\ManyToOne(inversedBy: 'purshaseProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ProductInStorage $productInStorage;

    #[ORM\Column]
    private int $amount;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPurshase(): Purshase
    {
        return $this->purshase;
    }

    public function setPurshase(Purshase $purshase): static
    {
        $this->purshase = $purshase;

        return $this;
    }

    public function getProductInStorage(): ProductInStorage
    {
        return $this->productInStorage;
    }

    public function setProductInStorage(ProductInStorage $productInStorage): static
    {
        $this->productInStorage = $productInStorage;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }
}
