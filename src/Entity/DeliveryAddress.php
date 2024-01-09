<?php

namespace App\Entity;

use App\Repository\DeliveryAddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeliveryAddressRepository::class)]
class DeliveryAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'deliveryAddresses', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, onDelete:'CASCADE')]
    private ?Client $client = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column]
    private ?int $houseNum = null;

    #[ORM\Column]
    private ?int $apartmentNum = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getHouseNum(): ?int
    {
        return $this->houseNum;
    }

    public function setHouseNum(int $houseNum): static
    {
        $this->houseNum = $houseNum;

        return $this;
    }

    public function getApartmentNum(): ?int
    {
        return $this->apartmentNum;
    }

    public function setApartmentNum(int $apartmentNum): static
    {
        $this->apartmentNum = $apartmentNum;

        return $this;
    }
}
