<?php

namespace App\DTO\Request;

//use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\City;
use App\Entity\Client;

final class DeliveryAddressDTO
{
    #[Assert\NotBlank]
    private Client $client;

    #[Assert\NotBlank]
    private City $city;

    #[Assert\NotBlank]
    private string $street;

    #[Assert\NotBlank]
    #[Assert\Positive]
    private int $houseNum;

    #[Assert\NotBlank]
    #[Assert\Positive]
    private int $apartmentNum;

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getHouseNum(): int
    {
        return $this->houseNum;
    }

    public function setHouseNum(int $houseNum): self
    {
        $this->houseNum = $houseNum;

        return $this;
    }

    public function getApartmentNum(): int
    {
        return $this->apartmentNum;
    }

    public function setApartmentNum(int $apartmentNum): self
    {
        $this->apartmentNum = $apartmentNum;

        return $this;
    }
}