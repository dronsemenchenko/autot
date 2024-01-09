<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private string $phone;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surname = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: DeliveryAddress::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $deliveryAddresses;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Purshase::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $purshases;

    public function __construct()
    {
        $this->deliveryAddresses = new ArrayCollection();
        $this->purshases = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return Collection<int, DeliveryAddress>
     */
    public function getDeliveryAddresses(): Collection
    {
        return $this->deliveryAddresses;
    }

    public function addDeliveryAddress(DeliveryAddress $deliveryAddress): static
    {
        if (!$this->deliveryAddresses->contains($deliveryAddress)) {
            $this->deliveryAddresses->add($deliveryAddress);
            $deliveryAddress->setClient($this);
        }

        return $this;
    }

    public function removeDeliveryAddress(DeliveryAddress $deliveryAddress): static
    {
        if ($this->deliveryAddresses->removeElement($deliveryAddress)) {
            // set the owning side to null (unless already changed)
            if ($deliveryAddress->getClient() === $this) {
                $deliveryAddress->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Purshase>
     */
    public function getPurshases(): Collection
    {
        return $this->purshases;
    }

    public function addPurshase(Purshase $purshase): static
    {
        if (!$this->purshases->contains($purshase)) {
            $this->purshases->add($purshase);
            $purshase->setClient($this);
        }

        return $this;
    }

    public function removePurshase(Purshase $purshase): static
    {
        if ($this->purshases->removeElement($purshase)) {
            // set the owning side to null (unless already changed)
            if ($purshase->getClient() === $this) {
                $purshase->setClient(null);
            }
        }

        return $this;
    }
}
