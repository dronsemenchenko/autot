<?php

namespace App\Entity;

use App\Repository\PurshaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurshaseRepository::class)]
class Purshase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $extTrackNum = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'purshases', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Client $client;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PurshaseStatus $purshaseStatus = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $priceDelivery = null;

    #[ORM\OneToMany(mappedBy: 'purshase', targetEntity: PurshaseProduct::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $purshaseProducts;

    public function __construct()
    {
        $this->purshaseProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtTrackNum(): ?string
    {
        return $this->extTrackNum;
    }

    public function setExtTrackNum(?string $extTrackNum): static
    {
        $this->extTrackNum = $extTrackNum;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getPurshaseStatus(): ?PurshaseStatus
    {
        return $this->purshaseStatus;
    }

    public function setPurshaseStatus(?PurshaseStatus $purshaseStatus): static
    {
        $this->purshaseStatus = $purshaseStatus;

        return $this;
    }

    public function getPriceDelivery(): ?string
    {
        return $this->priceDelivery;
    }

    public function setPriceDelivery(?string $priceDelivery): static
    {
        $this->priceDelivery = $priceDelivery;

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
            $purshaseProduct->setPurshase($this);
        }

        return $this;
    }

    public function removePurshaseProduct(PurshaseProduct $purshaseProduct): static
    {
        if ($this->purshaseProducts->removeElement($purshaseProduct)) {
            // set the owning side to null (unless already changed)
            if ($purshaseProduct->getPurshase() === $this) {
                $purshaseProduct->setPurshase(null);
            }
        }

        return $this;
    }
}
