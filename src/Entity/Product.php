<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductInStorage::class)]
    private Collection $productInStorages;

    public function __construct()
    {
        $this->productInStorages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ProductInStorage>
     */
    public function getProductInStorages(): Collection
    {
        return $this->productInStorages;
    }

    public function addProductInStorage(ProductInStorage $productInStorage): static
    {
        if (!$this->productInStorages->contains($productInStorage)) {
            $this->productInStorages->add($productInStorage);
            $productInStorage->setProduct($this);
        }

        return $this;
    }

    public function removeProductInStorage(ProductInStorage $productInStorage): static
    {
        if ($this->productInStorages->removeElement($productInStorage)) {
            // set the owning side to null (unless already changed)
            if ($productInStorage->getProduct() === $this) {
                $productInStorage->setProduct(null);
            }
        }

        return $this;
    }
}
