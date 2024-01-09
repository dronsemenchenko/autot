<?php

namespace App\Entity;

use App\Repository\ProductInStorageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductInStorageRepository::class)]
class ProductInStorage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Storage $storage = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\OneToMany(mappedBy: 'productInStorage', targetEntity: PurshaseProduct::class)]
    private Collection $purshaseProducts;

    public function __construct()
    {
        $this->purshaseProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStorage(): ?Storage
    {
        return $this->storage;
    }

    public function setStorage(?Storage $storage): static
    {
        $this->storage = $storage;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

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

    /**
     * @return Collection<int, PurshaseProduct>
     */
    public function getPurshaseProducts(): Collection
    {
        return $this->purshaseProducts;
    }

    public function addPurshaseProduct(PurshaseProduct $purshaseProduct): static
    {
        if (!$this->purshaseProducts->contains($purshaseProduct)) {
            $this->purshaseProducts->add($purshaseProduct);
            $purshaseProduct->setProductInStorage($this);
        }

        return $this;
    }

    public function removePurshaseProduct(PurshaseProduct $purshaseProduct): static
    {
        if ($this->purshaseProducts->removeElement($purshaseProduct)) {
            // set the owning side to null (unless already changed)
            if ($purshaseProduct->getProductInStorage() === $this) {
                $purshaseProduct->setProductInStorage(null);
            }
        }

        return $this;
    }
}
